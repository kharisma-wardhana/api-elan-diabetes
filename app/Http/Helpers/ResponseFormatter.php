<?php

namespace App\Http\Helpers;

use Illuminate\Http\JsonResponse;

class ResponseFormatter
{
    protected static $response = [
        'meta' => [
            'code' => JsonResponse::HTTP_OK,
            'status' => 'success',
            'message' => null,
        ],
        'data' => null,
    ];

    public static function success(
        $data = null,
        $message = null
    ): JsonResponse {
        self::$response['meta']['message'] = $message;
        self::$response['data'] = $data;

        return response()->json(
            self::$response,
            self::$response['meta']['code']
        );
    }

    public static function clientError(
        $data = null,
        $message = null
    ): JsonResponse {
        return ResponseFormatter::error(
            $data,
            $message,
            JsonResponse::HTTP_BAD_REQUEST
        );
    }

    public static function serverError(
        $data = null,
        $message = null
    ): JsonResponse {
        return ResponseFormatter::error(
            $data,
            $message,
            JsonResponse::HTTP_INTERNAL_SERVER_ERROR
        );
    }

    public static function error(
        $data = null,
        $message = 'Something went wrong',
        $code = null
    ): JsonResponse {
        self::$response['meta']['code'] = $code;
        self::$response['meta']['status'] = 'error';
        self::$response['meta']['message'] = $message;
        self::$response['data'] = $data;

        return response()->json(
            self::$response,
            self::$response['meta']['code']
        );
    }
}
