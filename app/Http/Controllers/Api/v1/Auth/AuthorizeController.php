<?php

namespace App\Http\Controllers\Api\v1\Auth;

use App\Traits\ApiWrapper;
use App\Models\User;
use Illuminate\Http\Request;
use Laravel\Passport\Http\Controllers\AccessTokenController;
use Psr\Http\Message\ServerRequestInterface;
use League\OAuth2\Server\AuthorizationServer;
use League\OAuth2\Server\CryptTrait;

class AuthorizeController extends AccessTokenController
{
    use CryptTrait, ApiWrapper;
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    protected $encryptionKey;

    public function __construct(AuthorizationServer $server)
    {
        $this->server        = $server;
        $this->encryptionKey = app('encrypter')->getKey();
    }

    public function __invoke(Request $request, ServerRequestInterface $psrRequest)
    {

        $authCodePayload = \json_decode($this->decrypt($request->code));

        $main = User::where('id', $authCodePayload->user_id)->first();

        $response = $this->issueToken($psrRequest->withParsedBody([
            'grant_type'    => 'authorization_code',
            'client_id'     => '9a07e012-1c73-4aa2-9abe-1e49e95457a6',
            'redirect_uri'  => config('app.url') . '/api/v1/auth/callback',
            'code_verifier' => $request->verifier,
            'code'          => $request->code,
        ]));

        $authorizerData       = json_decode($response->getContent());
        $authorizerData->user = $main;
        return $this->successResponse($authorizerData);
    }
}