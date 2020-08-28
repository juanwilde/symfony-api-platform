<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Uid\Uuid;

class Group
{
    private string $id;
    private string $name;
    private User $owner;
    private \DateTime $createdAt;
    private \DateTime $updatedAt;
    private Collection $users;
    private Collection $categories;
    private Collection $movements;

    public function __construct(string $name, User $owner)
    {
        $this->id = Uuid::v4()->toRfc4122();
        $this->name = $name;
        $this->owner = $owner;
        $this->createdAt = new \DateTime();
        $this->markAsUpdated();
        $this->users = new ArrayCollection([$owner]);
        $owner->addGroup($this);
        $this->categories = new ArrayCollection();
        $this->movements = new ArrayCollection();
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

    public function getOwner(): User
    {
        return $this->owner;
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

    /**
     * @return Collection|User[]
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): void
    {
        if ($this->users->contains($user)) {
            return;
        }

        $this->users->add($user);
    }

    public function removeUser(User $user): void
    {
        if ($this->users->contains($user)) {
            $this->users->removeElement($user);
        }
    }

    public function containsUser(User $user): bool
    {
        return $this->users->contains($user);
    }

    public function isOwnedBy(User $user): bool
    {
        return $this->owner->getId() === $user->getId();
    }

    /**
     * @return Collection|Category[]
     */
    public function getCategories(): Collection
    {
        return $this->categories;
    }

    /**
     * @return Collection|Movement[]
     */
    public function getMovements(): Collection
    {
        return $this->movements;
    }
}
