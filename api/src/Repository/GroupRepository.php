<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Group;
use App\Exception\Group\GroupNotFoundException;

class GroupRepository extends BaseRepository
{
    protected static function entityClass(): string
    {
        return Group::class;
    }

    public function findOneByIdOrFail(string $id): Group
    {
        if (null === $group = $this->objectRepository->find($id)) {
            throw GroupNotFoundException::fromId($id);
        }

        return $group;
    }
}
