<?php

namespace App\Helpers;

class ApiFormatter
{
    public static function response($code = 200, $message = "Success", $data = [], $meta = [])
    {
        if ($data) {
            $data = ['data' => $data];
        }
        if ($meta) {
            $meta = ['meta' => $meta];
        }
        return response()->json([
            'code'    => $code,
            'message' => $message,
            ...$meta ?? [],
            ...$data ?? ['data' => null],
        ], $code);
    }

    public static function paginateResponses($code = 200, $message = "Success", $data = null, $meta = null)
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
            'code'    => $code,
            'message' => $message,
            'meta'    => [
                ...$currentPage ?? [],
                ...$lastPage ?? [],
                ...$perPage ?? [],
                ...$total ?? [],
                ...$meta ?? [],
            ],
            ...$data ?? [],

        ], $code);
    }
    public static function responses($code = 200, $message = "Success", $data = null, $meta = null) : \Illuminate\Http\JsonResponse
    {
        if ($meta) {
            $meta = ['meta' => $meta];
        }
        return response()->json([
            'code'    => $code,
            'message' => $message,
            ...$meta ?? [],
            'data'    => $data,
        ], $code);
    }
}