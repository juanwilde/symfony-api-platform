<?php

declare(strict_types=1);

namespace App\Api\Action\Group;

use App\Entity\User;
use App\Service\Group\SendRequestToUserService;
use App\Service\Request\RequestService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class SendRequestToUser
{
    private SendRequestToUserService $sendRequestToUserService;

    public function __construct(SendRequestToUserService $sendRequestToUserService)
    {
        $this->sendRequestToUserService = $sendRequestToUserService;
    }

    public function __invoke(Request $request, User $user, string $id): JsonResponse
    {
        $this->sendRequestToUserService->send($id, RequestService::getField($request, 'email'), $user->getId());

        return new JsonResponse(['message' => 'The request has been sent!']);
    }
}
