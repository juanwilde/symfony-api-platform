<?php

declare(strict_types=1);

namespace App\Exception\File;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class FileNotFoundException extends NotFoundHttpException
{
    public function __construct()
    {
        parent::__construct('File not found in the server');
    }
}
