<?php

declare(strict_types=1);

namespace App\Services\gorest\DataObjects;

use Symfony\Component\Validator\Constraints as Assert;

final class GetUsersRequestDto
{
    #[Assert\NotNull(message: 'Page number cannot be null')]
    #[Assert\Type(type: 'integer', message: 'Page must be an integer')]
    #[Assert\GreaterThan(value: 0, message: 'Page must be greater than 0')]
    private int $page;

    #[Assert\NotNull(message: 'Items per page cannot be null')]
    #[Assert\Type(type: 'integer', message: 'Items per page must be an integer')]
    #[Assert\GreaterThan(value: 0, message: 'Items per page must be greater than 0')]
    #[Assert\LessThanOrEqual(value: 100, message: 'Items per page cannot exceed 100')]
    private int $perPage;

    #[Assert\Type(type: 'string', message: 'Search query must be a string')]
    #[Assert\Length(
        max: 255,
        maxMessage: 'Search query cannot be longer than {{ limit }} characters'
    )]
    private string $searchQuery;

    public function __construct(int $page = 1, int $perPage = 10, ?string $searchQuery = '')
    {
        $this->page = $page;
        $this->perPage = $perPage;
        $this->searchQuery = $searchQuery ?? '';
    }

    public function getPage(): int
    {
        return $this->page;
    }

    public function getPerPage(): int
    {
        return $this->perPage;
    }

    public function getSearchQuery(): string
    {
        return $this->searchQuery;
    }

    public function setPage(int $page): self
    {
        $this->page = $page;

        return $this;
    }

    public function setPerPage(int $perPage): self
    {
        $this->perPage = $perPage;

        return $this;
    }

    public function setSearchQuery(?string $searchQuery): self
    {
        $this->searchQuery = $searchQuery ?? '';

        return $this;
    }

    public function toArray(): array
    {
        return [
            'page' => $this->page,
            'perPage' => $this->perPage,
            'searchQuery' => $this->searchQuery,
        ];
    }
}
