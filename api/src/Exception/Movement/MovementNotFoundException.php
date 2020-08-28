<?php

declare(strict_types=1);

namespace App\Exception\Movement;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class MovementNotFoundException extends NotFoundHttpException
{
    private const MESSAGE_NOT_FOUND_BY_ID = 'Movement with id %s not found';
    private const MESSAGE_NOT_FOUND_BY_FILE_PATH = 'Movement with filePath %s not found';

    public static function fromId(string $id): self
    {
        throw new self(\sprintf(self::MESSAGE_NOT_FOUND_BY_ID, $id));
    }

    public static function fromFilePath(string $filePath): self
    {
        throw new self(\sprintf(self::MESSAGE_NOT_FOUND_BY_FILE_PATH, $filePath));
    }
}
