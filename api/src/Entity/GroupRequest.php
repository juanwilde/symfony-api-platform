<?php

declare(strict_types=1);

namespace App\Entity;

use Symfony\Component\Uid\Uuid;

class GroupRequest
{
    public const PENDING = 'pending';
    public const ACCEPTED = 'accepted';

    private string $id;
    private Group $group;
    private User $user;
    private string $token;
    private string $status;
    private ?\DateTime $acceptedAt;

    public function __construct(Group $group, User $user)
    {
        $this->id = Uuid::v4()->toRfc4122();
        $this->group = $group;
        $this->user = $user;
        $this->token = \sha1(\uniqid());
        $this->status = self::PENDING;
        $this->acceptedAt = null;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getGroup(): Group
    {
        return $this->group;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function getToken(): string
    {
        return $this->token;
    }

    public function setToken(string $token): void
    {
        $this->token = $token;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function setStatus(string $status): void
    {
        $this->status = $status;
    }

    public function getAcceptedAt(): ?\DateTime
    {
        return $this->acceptedAt;
    }

    public function setAcceptedAt(?\DateTime $acceptedAt): void
    {
        $this->acceptedAt = $acceptedAt;
    }
}
