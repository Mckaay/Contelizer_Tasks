<?php

declare(strict_types=1);

namespace App\Services\gorest\Validators;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Validator\ValidatorInterface;

interface RequestValidator
{
    public static function validate(Request $request, ValidatorInterface $validator);
}
