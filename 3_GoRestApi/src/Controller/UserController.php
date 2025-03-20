<?php

declare(strict_types=1);

namespace App\Controller;

use App\Services\gorest\DataObjects\GetUsersRequestDto;
use App\Services\gorest\DataObjects\UserDto;
use App\Services\gorest\Enums\HTTPMethod;
use App\Services\gorest\Exceptions\GoRestApiException;
use App\Services\gorest\GoRestApiClient;
use App\Services\gorest\Traits\ApiResponseTrait;
use App\Services\gorest\Validators\GetUsersRequestValidator;
use App\Services\gorest\Validators\UpdateUserRequestValidator;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Throwable;

#[AsController]
#[Route('/api')]
final class UserController
{
    use ApiResponseTrait;

    public function __construct(
        private readonly GoRestApiClient $goRestApiClient,
        private readonly ValidatorInterface $validator,
    ) {}

    #[Route('/users', name: 'getUsers', methods: [HTTPMethod::GET->value])]
    public function index(Request $request): JsonResponse
    {
        try {
            $request = GetUsersRequestValidator::validate($request, $this->validator);

            if ((!$request instanceof GetUsersRequestDto)) {
                return $this->createValidationErrorResponse($request);
            }

            $users = $this->goRestApiClient->getUsers($request->getPage(), $request->getPerPage(), $request->getSearchQuery());

            return $this->createSuccessResponse($users);
        } catch (GoRestApiException $exception) {
            return $this->createErrorResponse(
                $exception->getMessage(),
                $exception->getCode(),
            );
        } catch (Throwable) {
            return $this->createErrorResponse(
                'An unexpected error occurred.',
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    #[Route('/users/{id}', name: 'updateUser', methods: [HTTPMethod::PUT->value])]
    public function update(Request $request, int $id): JsonResponse
    {
        try {
            $validate = UpdateUserRequestValidator::validate($request, $this->validator);

            if ( ! ($validate instanceof UserDto)) {
                return $this->createValidationErrorResponse($validate);
            }

            $users = $this->goRestApiClient->updateUser($validate);

            return $this->createSuccessResponse($users);
        } catch (GoRestApiException $exception) {
            return $this->createErrorResponse(
                $exception->getMessage(),
                $exception->getCode(),
            );
        } catch (Throwable $exception) {
            return $this->createErrorResponse(
                $exception->getMessage(),
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    #[Route('/users/{id}', name: 'deleteUser', methods: [HTTPMethod::DELETE->value])]
    public function delete(int $id): JsonResponse
    {
        try {
            $this->goRestApiClient->delete($id);

            return new JsonResponse(status: Response::HTTP_NO_CONTENT);
        } catch (GoRestApiException $exception) {
            return $this->createErrorResponse(
                $exception->getMessage(),
                $exception->getCode(),
            );
        } catch (Throwable $exception) {
            return $this->createErrorResponse(
                $exception->getMessage(),
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }
}
