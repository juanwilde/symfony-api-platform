<?php

declare(strict_types=1);

namespace App\Exception\GroupRequest;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class GroupRequestNotFoundException extends NotFoundHttpException
{
    private const MESSAGE = 'Pending group request with groupId %s, userId %s and token %s not found';

    public static function fromGroupIdUserIdAndToken(string $groupId, string $userId, string $token): self
    {
        throw new self(\sprintf(self::MESSAGE, $groupId, $userId, $token));
    }
}
