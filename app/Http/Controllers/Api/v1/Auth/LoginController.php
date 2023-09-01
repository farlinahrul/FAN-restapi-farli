<?php

namespace App\Http\Controllers\Api\v1\Auth;

use App\Traits\ApiWrapper;
use App\Http\Controllers\Controller;
use App\Http\Requests\AuthRequest\LoginRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class LoginController extends Controller
{
    use ApiWrapper;
    public function login(LoginRequest $request)
    {
        $user = User::firstWhere('email', $request->email);
        if ($user == null) {
            return $this->errorResponse(Response::HTTP_INTERNAL_SERVER_ERROR, 'email or password is incorrect');
        }
        $verifiedPassword = Hash::check($request->password, $user->password);

        if ($verifiedPassword) {
            $query = http_build_query([
                'client_id'             => '9a07e012-1c73-4aa2-9abe-1e49e95457a6',
                'redirect_uri'          => config('app.url') . '/api/v1/auth/callback',
                'response_type'         => 'code',
                'scope'                 => '',
                'state'                 => $request['state'],
                'code_challenge'        => $request['challenge'],
                'code_challenge_method' => 'S256',
                'user'                  => $user->id
            ]);
            return redirect()->intended(config('app.url') . '/api/v1/auth/oauth/authorize?' . $query);
        }

        return $this->errorResponse(Response::HTTP_UNAUTHORIZED, 'email or password is incorrect');
    }
}