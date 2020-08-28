<?php

declare(strict_types=1);

namespace App\Exception\Movement;

use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class CannotUseThisCategoryInMovementException extends AccessDeniedHttpException
{
    public function __construct()
    {
        parent::__construct('You can not user this category in this movement');
    }
}
