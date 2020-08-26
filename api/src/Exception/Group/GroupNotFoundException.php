<?php

declare(strict_types=1);

namespace App\Exception\Group;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class GroupNotFoundException extends NotFoundHttpException
{
    private const MESSAGE = 'Group with id %s not found';

    public static function fromId(string $id): self
    {
        throw new self(\sprintf(self::MESSAGE, $id));
    }
}
