<?php

namespace App\Traits;

use App\Http\Controllers\Controller;
use Illuminate\Http\Response;

trait ApiWrapper
{
    public function successResponse($data = [], $meta = [], $message = "Success")
    {
        if ($data) {
            $data = ['data' => $data];
        }
        if ($meta) {
            $meta = ['meta' => $meta];
        }
        return response()->json([
            'success' => true,
            'message' => $message,
            ...$meta ?? [],
            ...$data ?? ['data' => null],
        ], Response::HTTP_OK);
    }

    public function errorResponse($code = Response::HTTP_NOT_FOUND, string $message)
    {
        return response()->json([
            'success' => false,
            'message' => $message
        ], $code);
    }
}