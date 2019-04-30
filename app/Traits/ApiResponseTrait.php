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

    public function exceptionResponse(string $exceptionMessage, $status=500)
    {
        return response()->json(['message'  =>  $exceptionMessage,], $status);
    }
}
