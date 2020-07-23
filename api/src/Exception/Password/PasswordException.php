<?php

declare(strict_types=1);

namespace App\Exception\Password;

use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class PasswordException extends BadRequestHttpException
{
    public static function invalidLength(): self
    {
        throw new self('Password must be at least 6 characters');
    }

    public static function oldPasswordDoesNotMatch(): self
    {
        throw new self('Old password does not match');
    }
}
