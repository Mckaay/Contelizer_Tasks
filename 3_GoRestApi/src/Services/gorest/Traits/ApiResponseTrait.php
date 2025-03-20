<?php

declare(strict_types=1);

namespace App\Services\gorest\Traits;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

trait ApiResponseTrait
{
    protected function createSuccessResponse(array $data, int $statusCode = Response::HTTP_OK): JsonResponse
    {
        return new JsonResponse(
            [
                'status' => 'success',
                'data' => $data,
            ],
            $statusCode
        );
    }

    protected function createErrorResponse(string $message, int $statusCode): JsonResponse
    {
        return new JsonResponse(
            [
                'status' => 'error',
                'message' => json_decode($message) ? json_decode($message) : $message,
            ],
            $statusCode
        );
    }

    protected function createValidationErrorResponse(array $errors, int $statusCode = Response::HTTP_UNPROCESSABLE_ENTITY): JsonResponse
    {
        return new JsonResponse(
            [
                'status' => 'Validation Errors',
                'errors' => $errors,
            ],
            $statusCode
        );
    }
}
