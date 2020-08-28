<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Movement;
use App\Exception\Movement\MovementNotFoundException;

class MovementRepository extends BaseRepository
{
    protected static function entityClass(): string
    {
        return Movement::class;
    }

    public function findOneByIdOrFail(string $id): Movement
    {
        if (null === $movement = $this->objectRepository->find($id)) {
            throw MovementNotFoundException::fromId($id);
        }

        return $movement;
    }

    public function findOneByFilePathOrFail(string $filePath): Movement
    {
        if (null === $movement = $this->objectRepository->findOneBy(['filePath' => $filePath])) {
            throw MovementNotFoundException::fromFilePath($filePath);
        }

        return $movement;
    }

    public function save(Movement $movement): void
    {
        $this->saveEntity($movement);
    }
}
