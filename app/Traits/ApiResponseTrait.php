<?php

namespace App\Traits;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Response;

trait ApiResponseTrait
{
    public function errorResponse($errors, $message, $code): Application|ResponseFactory|Response
    {
        return \response(["errors" => $errors, "message" => $message], $code, [
            "Content-Type" => "application/json"
        ]);
    }

    public function successResponse($data, $message = "Success", $code = 200): Response|ResponseFactory
    {
        return \response(["data" => $data, "message" => $message], $code, [
            "Content-Type" => "application/json"
        ]);
    }

    public function pageResponse($data, $message, $code): Response|ResponseFactory
    {
        return \response([
            "data" => $data,
            "page" => "",
            "message" => $message
        ],
            $code,
            [
                "Content-Type" => "application/json"
            ]);
    }
}
