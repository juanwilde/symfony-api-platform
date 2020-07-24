<?php

declare(strict_types=1);

namespace App\Exception\User;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class UserNotFoundException extends NotFoundHttpException
{
    private const MESSAGE = 'User with email %s not found';

    public static function fromEmail(string $email): self
    {
        throw new self(\sprintf(self::MESSAGE, $email));
    }

    public static function fromUserIdAndToken(string $id, string $token): self
    {
        throw new self(\sprintf('User with id %s and token %s not found', $id, $token));
    }

    public static function fromUserIdAndResetPasswordToken(string $id, string $resetPasswordToken): self
    {
        throw new self(\sprintf('User with id %s and resetPasswordToken %s not found', $id, $resetPasswordToken));
    }

    public static function fromUserId(string $id): self
    {
        throw new self(\sprintf('User with id %s not found', $id));
    }
}
