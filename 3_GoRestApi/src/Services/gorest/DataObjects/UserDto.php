<?php

declare(strict_types=1);

namespace App\Services\gorest\DataObjects;

use App\Services\gorest\Enums\Gender;
use App\Services\gorest\Enums\Status;
use Symfony\Component\Validator\Constraints as Assert;

final class UserDto
{
    #[Assert\NotNull(message: 'ID cannot be null')]
    #[Assert\Type(type: 'string', message: 'ID must be a string')]
    #[Assert\NotBlank(message: 'ID cannot be blank')]
    private string $id;

    #[Assert\NotNull(message: 'Name cannot be null')]
    #[Assert\Type(type: 'string', message: 'Name must be a string')]
    #[Assert\NotBlank(message: 'Name cannot be blank')]
    #[Assert\Length(
        max: 255,
        maxMessage: 'Name cannot be longer than {{ limit }} characters'
    )]
    private string $name;

    #[Assert\NotNull(message: 'Email cannot be null')]
    #[Assert\Type(type: 'string', message: 'Email must be a string')]
    #[Assert\NotBlank(message: 'Email cannot be blank')]
    #[Assert\Email(message: 'Email must be a valid email address')]
    private string $email;

    #[Assert\NotNull(message: 'Gender is required and needs to be either female or male')]
    private ?Gender $gender;

    #[Assert\NotNull(message: 'Status is required and needs to be either active or inactive')]
    private ?Status $status;

    public function __construct(string $id, string $name, string $email, ?Gender $gender, ?Status $status)
    {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->gender = $gender;
        $this->status = $status;
    }

    public static function create(string $id, string $name, string $email, Gender $gender, Status $status): self
    {
        return new self($id, $name, $email, $gender, $status);
    }

    public static function fromRequestContent(array $content): self
    {
        $id = $content['id'] ?? '';
        $name = $content['name'] ?? '';
        $email = $content['email'] ?? '';
        $gender = isset($content['gender']) ? Gender::tryFrom($content['gender']) : null;
        $status = isset($content['status']) ? Status::tryFrom($content['status']) : null;

        return new self($id, $name, $email, $gender, $status);
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getGender(): Gender
    {
        return $this->gender;
    }

    public function getStatus(): Status
    {
        return $this->status;
    }

    public function setId(string $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function setGender(Gender $gender): self
    {
        $this->gender = $gender;

        return $this;
    }

    public function setStatus(Status $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'gender' => $this->gender->value,
            'status' => $this->status->value,
        ];
    }
}
