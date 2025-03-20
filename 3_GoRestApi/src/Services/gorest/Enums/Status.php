<?php

declare(strict_types=1);

namespace App\Services\gorest\Enums;

enum Status: string
{
    case ACTIVE = 'active';
    case INACTIVE = 'inactive';
}
