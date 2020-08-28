<?php

declare(strict_types=1);

namespace App\Tests\Functional\Movement;

use Symfony\Component\HttpFoundation\JsonResponse;

class DeleteMovementTest extends MovementTestBase
{
    public function testDeleteMovement(): void
    {
        self::$peter->request('DELETE', \sprintf('%s/%s', $this->endpoint, $this->getPeterMovementId()));

        $response = self::$peter->getResponse();

        $this->assertEquals(JsonResponse::HTTP_NO_CONTENT, $response->getStatusCode());
    }

    public function testDeleteGroupMovement(): void
    {
        self::$peter->request('DELETE', \sprintf('%s/%s', $this->endpoint, $this->getPeterGroupMovementId()));

        $response = self::$peter->getResponse();

        $this->assertEquals(JsonResponse::HTTP_NO_CONTENT, $response->getStatusCode());
    }

    public function testDeleteAnotherUserMovement(): void
    {
        self::$brian->request('DELETE', \sprintf('%s/%s', $this->endpoint, $this->getPeterMovementId()));

        $response = self::$brian->getResponse();

        $this->assertEquals(JsonResponse::HTTP_FORBIDDEN, $response->getStatusCode());
    }

    public function testDeleteAnotherGroupMovement(): void
    {
        self::$brian->request('DELETE', \sprintf('%s/%s', $this->endpoint, $this->getPeterGroupMovementId()));

        $response = self::$brian->getResponse();

        $this->assertEquals(JsonResponse::HTTP_FORBIDDEN, $response->getStatusCode());
    }
}
