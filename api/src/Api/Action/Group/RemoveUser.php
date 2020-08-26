<?php

declare(strict_types=1);

namespace App\Api\Action\Group;

use App\Entity\User;
use App\Service\Group\RemoveUserService;
use App\Service\Request\RequestService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class RemoveUser
{
    private RemoveUserService $removeUserService;

    public function __construct(RemoveUserService $removeUserService)
    {
        $this->removeUserService = $removeUserService;
    }

    /**
     * @throws \Throwable
     */
    public function __invoke(Request $request, User $user, string $id): JsonResponse
    {
        $this->removeUserService->remove($id, RequestService::getField($request, 'userId'), $user);

        return new JsonResponse(['message' => 'The user has been removed!']);
    }
}
