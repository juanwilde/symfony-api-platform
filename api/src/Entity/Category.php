<?php

declare(strict_types=1);

namespace App\Entity;

use Symfony\Component\Uid\Uuid;

class Category
{
    public const EXPENSE = 'expense';
    public const INCOME = 'income';

    private string $id;
    private string $name;
    private string $type;
    private User $owner;
    private ?Group $group;
    private \DateTime $createdAt;
    private \DateTime $updatedAt;

    public function __construct(string $name, string $type, User $owner, Group $group = null)
    {
        $this->id = Uuid::v4()->toRfc4122();
        $this->name = $name;
        $this->type = $type;
        $this->owner = $owner;
        $this->group = $group;
        $this->createdAt = new \DateTime();
        $this->markAsUpdated();
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getOwner(): User
    {
        return $this->owner;
    }

    public function getGroup(): ?Group
    {
        return $this->group;
    }

    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): \DateTime
    {
        return $this->updatedAt;
    }

    public function markAsUpdated(): void
    {
        $this->updatedAt = new \DateTime();
    }

    public function isOwnedBy(User $user): bool
    {
        return $this->owner->getId() === $user->getId();
    }
}
