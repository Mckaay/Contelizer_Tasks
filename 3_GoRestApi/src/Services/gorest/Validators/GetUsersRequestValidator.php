<?php

declare(strict_types=1);

namespace App\Services\gorest\Validators;

use App\Services\gorest\DataObjects\GetUsersRequestDto;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final class GetUsersRequestValidator implements RequestValidator
{
    public static function validate(Request $request, ValidatorInterface $validator): array|GetUsersRequestDto
    {
        $perPage = $request->query->getInt('per_page', 20);
        $page = $request->query->getInt('page', 1);
        $searchQuery = $request->query->getAlnum('query', '');

        $getUsersRequest = new GetUsersRequestDto($page, $perPage, $searchQuery);

        $errors = $validator->validate($getUsersRequest);
        if (count($errors) > 0) {
            $errorsArray = [];
            foreach ($errors as $error) {
                $errorsArray[] = $error->getMessage();
            }

            return $errorsArray;
        }

        return $getUsersRequest;
    }
}
