<?php

namespace App\Helpers;

use App\Constants\HttpStatusCode;
use App\Constants\Message;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Response;

class ResponseHelper
{
    /**
     * Trả về response thành công
     */
    public static function success(
        $data = null,
        string $message = null,
        int $statusCode = HttpStatusCode::OK
    ): JsonResponse {
        return Response::json([
            'success' => true,
            'message' => $message ?? Message::SUCCESS,
            'data' => $data,
        ], $statusCode);
    }

    /**
     * Trả về response lỗi
     */
    public static function error(
        string $message = null,
        $errors = null,
        int $statusCode = HttpStatusCode::BAD_REQUEST
    ): JsonResponse {
        $response = [
            'success' => false,
            'message' => $message ?? Message::ERROR,
        ];

        if ($errors) {
            $response['errors'] = $errors;
        }

        return Response::json($response, $statusCode);
    }

    /**
     * Trả về response validation error
     */
    public static function validationError($errors, string $message = null): JsonResponse
    {
        return self::error(
            $message ?? Message::VALIDATION_ERROR,
            $errors,
            HttpStatusCode::VALIDATION_ERROR
        );
    }

    /**
     * Trả về response not found
     */
    public static function notFound(string $message = null): JsonResponse
    {
        return self::error(
            $message ?? Message::NOT_FOUND,
            null,
            HttpStatusCode::NOT_FOUND
        );
    }

    /**
     * Trả về redirect với message
     */
    public static function redirectWithMessage(
        string $route,
        string $message,
        string $type = 'success'
    ): RedirectResponse {
        return redirect()->route($route)->with($type, $message);
    }

    /**
     * Trả về redirect với errors (cho validation)
     */
    public static function redirectWithErrors(
        string $route,
        $errors,
        string $message = null
    ): RedirectResponse {
        return redirect()->route($route)
            ->withErrors($errors)
            ->withInput()
            ->with('error', $message ?? Message::VALIDATION_ERROR);
    }
}

