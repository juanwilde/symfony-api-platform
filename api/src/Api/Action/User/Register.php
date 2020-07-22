<?php

declare(strict_types=1);

namespace App\Api\Action\User;

use App\Entity\User;
use App\Service\User\UserRegisterService;
use Symfony\Component\HttpFoundation\Request;

class Register
{
    private UserRegisterService $userRegisterService;

    public function __construct(UserRegisterService $userRegisterService)
    {
        $this->userRegisterService = $userRegisterService;
    }

    public function __invoke(Request $request): User
    {
        return $this->userRegisterService->create($request);
    }
}
