<?php

declare(strict_types=1);

namespace App\Services\gorest;

use App\Services\gorest\DataObjects\UserDTO;
use App\Services\gorest\Enums\HTTPMethod;
use App\Services\gorest\Exceptions\GoRestApiException;
use Symfony\Component\HttpClient\Exception\ClientException;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Throwable;

final readonly class GoRestApiClient
{
    public function __construct(
        private HttpClientInterface $httpClient
    ) {}

    /**
     * @throws GoRestApiException
     */
    public function getUsers(int $page = 1, int $perPage = 10, string $query = ''): array
    {
        try {
            $response = $this->httpClient->request(
                HTTPMethod::GET->value,
                'users',
                [
                    'query' => [
                        'page' => $page,
                        'per_page' => $perPage,
                        'name' => $query,
                    ],
                ]
            );

            return $response->toArray();
        } catch (ClientException $exception) {
            throw new GoRestApiException(
                $exception->getMessage(),
                $exception->getCode(),
                $exception
            );
        } catch (Throwable $exception) {
            throw new GoRestApiException(
                'An error occurred while communicating with the GoRest API',
                0,
                $exception
            );
        }
    }

    /**
     * @throws GoRestApiException
     */
    public function updateUser(UserDTO $userDto): array
    {
        try {
            $response = $this->httpClient->request(
                HTTPMethod::PUT->value,
                'users/' . $userDto->getId(),
                [
                    'body' => json_encode($userDto->toArray()),
                ]
            );

            return $response->toArray();
        } catch (ClientException $exception) {
            throw new GoRestApiException(
                json_encode(json_decode($exception->getResponse()->getContent(false)), JSON_PRETTY_PRINT),
                $exception->getCode(),
                $exception
            );
        } catch (Throwable $exception) {
            throw new GoRestApiException(
                'An error occurred while communicating with the GoRest API',
                0,
                $exception
            );
        }
    }

    /**
     * @throws GoRestApiException
     */
    public function delete(int $id): array
    {
        try {
            $this->httpClient->request(
                HTTPMethod::DELETE->value,
                'users/' . $id
            );

            return [];
        } catch (ClientException $exception) {
            throw new GoRestApiException(
                json_encode(json_decode($exception->getResponse()->getContent(false)), JSON_PRETTY_PRINT),
                $exception->getCode(),
                $exception
            );
        } catch (Throwable $exception) {
            throw new GoRestApiException(
                'An error occurred while communicating with the GoRest API',
                0,
                $exception
            );
        }
    }
}
