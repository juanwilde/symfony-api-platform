<?php

declare(strict_types=1);

namespace App\Api\Action\Group;

use App\Service\Group\AcceptRequestService;
use App\Service\Request\RequestService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class AcceptRequest
{
    private AcceptRequestService $acceptRequestService;

    public function __construct(AcceptRequestService $acceptRequestService)
    {
        $this->acceptRequestService = $acceptRequestService;
    }

    /**
     * @throws \Throwable
     */
    public function __invoke(Request $request, string $id): JsonResponse
    {
        $this->acceptRequestService->accept(
            $id,
            RequestService::getField($request, 'userId'),
            RequestService::getField($request, 'token')
        );

        return new JsonResponse(['message' => 'The user has been added to the group']);
    }
}
