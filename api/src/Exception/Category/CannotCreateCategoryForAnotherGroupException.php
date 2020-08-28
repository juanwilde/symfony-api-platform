<?php

declare(strict_types=1);

namespace App\Exception\Category;

use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class CannotCreateCategoryForAnotherGroupException extends AccessDeniedHttpException
{
    public function __construct()
    {
        parent::__construct('You can not create categories for another group');
    }
}
