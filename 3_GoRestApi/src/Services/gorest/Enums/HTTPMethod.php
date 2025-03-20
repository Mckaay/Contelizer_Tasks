<?php

declare(strict_types=1);

namespace App\Services\gorest\Enums;

enum HTTPMethod: string
{
    case GET = 'GET';
    case POST = 'POST';
    case PUT = 'PUT';
    case DELETE = 'DELETE';
    case PATCH = 'PATCH';
}
