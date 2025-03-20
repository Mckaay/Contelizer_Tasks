<?php

declare(strict_types=1);

namespace App\Services\gorest\Validators;

use App\Services\gorest\DataObjects\UserDto;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final class UpdateUserRequestValidator implements RequestValidator
{
    public static function validate(Request $request, ValidatorInterface $validator): array|UserDto
    {
        $userId = (string) $request->attributes->get('id', '0');
        $userDto = UserDto::fromRequestContent(array_merge(['id' => $userId], $request->toArray()));
        $errors = $validator->validate($userDto);
        if (count($errors) > 0) {
            $errorsArray = [];
            foreach ($errors as $error) {
                $errorsArray[] = $error->getMessage();
            }

            return $errorsArray;
        }

        return $userDto;
    }
}
