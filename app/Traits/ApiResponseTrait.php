<?php

namespace App\Traits;

trait ApiResponseTrait
{
    public function successResponse(string $message, $data, $encryption = false)
    {
        return response()->json([
            'message'  =>  $message,
            'data'      =>  ($encryption) ? self::_encrypt_string(json_encode($data)) : $data
        ], 200);
    }

    public function exceptionResponse(string $exception)
    {
        return response()->json([
            'message'  =>  $exception,
            'data'     =>  null
        ], 500);
    }

    public function invalidResponse(string $message)
    {
        return response()->json([
            'message'  =>  $message,
            'data'      =>  null
        ], 422);
    }

    public function unauthorizedResponse(string $message)
    {
        return response()->json([
            'message'  =>  $message,
            'data'      =>  ""
        ], 401);
    }
}
