<?php

namespace App\Http\Controllers\Api\v1\Auth;

use App\Traits\ApiWrapper;
use App\Http\Controllers\Controller;
use App\Http\Requests\AuthRequest\RegisterRequest;
use App\Models\User;
use Symfony\Component\HttpFoundation\Response;

class RegisterController extends Controller
{
    use ApiWrapper;
    public function register(RegisterRequest $request)
    {
        $validated = $request->validated();

        // validate email
        $emailExist = User::where('email', $validated['email'])->first();
        if ($emailExist) {
            return $this->errorResponse(Response::HTTP_BAD_REQUEST, 'The email has already been taken.');
        }

        $validated['npp'] = User::orderBy('npp', 'desc')->first()->npp + 1;

        // insert data
        $validated['password'] = bcrypt($validated['password']);
        $user                  = User::create($validated);
        if ($user) {
            return $this->successResponse($user);
        }
        return $this->errorResponse(Response::HTTP_INTERNAL_SERVER_ERROR, Response::$statusTexts[Response::HTTP_INTERNAL_SERVER_ERROR]);
    }
}