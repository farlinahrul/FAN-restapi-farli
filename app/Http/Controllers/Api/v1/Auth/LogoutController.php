<?php

namespace App\Http\Controllers\Api\v1\Auth;

use App\Traits\ApiWrapper;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Laravel\Passport\TokenRepository;
use Laravel\Passport\RefreshTokenRepository;

class LogoutController extends Controller
{
    use ApiWrapper;

    public function __invoke($id)
    {
        try {
            if (Auth::user()->id == $id) {
                $tokenRepository        = app(TokenRepository::class);
                $refreshTokenRepository = app(RefreshTokenRepository::class);
                foreach (User::find(Auth::user()->id)->tokens as $token) {
                    $tokenRepository->revokeAccessToken($token->id);
                    $refreshTokenRepository->revokeRefreshTokensByAccessTokenId($token->id);
                }
                return $this->successResponse()->json(['message' => 'You are logout'], 200);
            }
            return $this->errorResponse(Response::HTTP_UNAUTHORIZED, 'Unauthorised');
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}