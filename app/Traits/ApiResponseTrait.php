<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;

trait ApiResponseTrait
{
    public function errorResponse($errors, $message, $code): JsonResponse
    {
        return \response()->json(["errors" => $errors, "message" => $message], $code);
    }

    public function successResponse($data, $message = "Success", $code = 200): JsonResponse
    {
        return \response()->json(["data" => $data, "message" => $message], $code);
    }

    public function pageResponse($data, $message, $code): JsonResponse
    {
        return \response()->json([
            "data" => $data,
            "page" => "",
            "message" => $message
        ], $code);
    }
}
