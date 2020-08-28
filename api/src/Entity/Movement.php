<?php

declare(strict_types=1);

namespace App\Entity;

use Symfony\Component\Uid\Uuid;

class Movement
{
    private string $id;
    private Category $category;
    private User $owner;
    private ?Group $group;
    private float $amount;
    private ?string $filePath;
    private \DateTime $createdAt;
    private \DateTime $updatedAt;

    public function __construct(Category $category, User $owner, float $amount, Group $group = null)
    {
        $this->id = Uuid::v4()->toRfc4122();
        $this->category = $category;
        $this->owner = $owner;
        $this->group = $group;
        $this->amount = $amount;
        $this->filePath = null;
        $this->createdAt = new \DateTime();
        $this->markAsUpdated();
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getCategory(): Category
    {
        return $this->category;
    }

    public function setCategory(Category $category): void
    {
        $this->category = $category;
    }

    public function getOwner(): User
    {
        return $this->owner;
    }

    public function getGroup(): ?Group
    {
        return $this->group;
    }

    public function getAmount(): float
    {
        return $this->amount;
    }

    public function setAmount(float $amount): void
    {
        $this->amount = $amount;
    }

    public function getFilePath(): ?string
    {
        return $this->filePath;
    }

    public function setFilePath(?string $filePath): void
    {
        $this->filePath = $filePath;
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

    public function belongsToGroup(Group $group)
    {
        if (null !== $group = $this->group) {
            return $group->getId() === $group->getId();
        }

        return false;
    }
}
