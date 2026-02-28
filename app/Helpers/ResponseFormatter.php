<?php

namespace App\Helpers;

class ResponseFormatter
{
    public static function success($data = null, $message = null, $code = 200)
    {
        return response()->json([
            'meta' => [
                'code' => $code,
                'status' => 'success',
                'message' => $message,
            ],
            'data' => $data,
        ], $code);
    }

    public static function error($data = null, $message = null, $code = 400)
    {
        return response()->json([
            'meta' => [
                'code' => $code,
                'status' => 'error',
                'message' => $message,
            ],
            'data' => $data,
        ], $code);
    }
}
