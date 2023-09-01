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

    public function successPaginateResponse($data = null, $meta = null, $message = "Success")
    {
        if ($data) {
            $data = $data->toArray();
            if ($meta) {
                $meta = ['meta' => $meta];
            }
            if ($data['current_page']) {
                $currentPage = ['current_page' => $data['current_page']];
            }
            if ($data['last_page']) {
                $lastPage = ['last_page' => $data['last_page']];
            }
            if ($data['total']) {
                $total = ['total' => $data['total']];
            }
            if ($data['per_page']) {
                $perPage = ['per_page' => $data['per_page']];
            }
            $data = ['data' => $data['data']];
        }
        return response()->json([
            'success' => true,
            'message' => $message,
            'meta'    => [
                ...$currentPage ?? [],
                ...$lastPage ?? [],
                ...$perPage ?? [],
                ...$total ?? [],
                ...$meta ?? [],
            ],
            ...$data ?? [],

        ], Response::HTTP_OK);
    }

    public function errorResponse($code = Response::HTTP_NOT_FOUND, string $message)
    {
        return response()->json([
            'data' => [
                'success' => false,
                'message' => $message
            ]
        ], $code);
    }
}