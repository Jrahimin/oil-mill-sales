<?php

namespace App\Traits;

trait ApiResponseTrait
{
    public function successResponse($data)
    {
        return response()->json($data, 200);
    }

    public function successResponseWithMsg(string $message)
    {
        return response()->json($message, 200);
    }

    public function exceptionResponse(string $exceptionMessage)
    {
        return response()->json([
            'message'  =>  $exceptionMessage,
            'data'     =>  null
        ], 500);
    }

    public function invalidResponse(string $message)
    {
        return response()->json([
            'message'  =>  $message,
            'data'     =>  null
        ], 422);
    }

    public function unauthorizedResponse(string $message)
    {
        return response()->json([
            'message'  =>  $message,
            'data'     =>  ""
        ], 401);
    }
}
