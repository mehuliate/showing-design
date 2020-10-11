<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Auth\Access\AuthorizationException;

class CustomException extends Exception
{
    public function render($request, Exception $exception)
    {
        if ($exception instanceof AuthorizationException) {
            if ($request->expectsJson()) {
                return response()->json(["errors" => [
                    "message" => "You are not authorized to access this resource"
                ]], 403);
            }
        }
    }
}
