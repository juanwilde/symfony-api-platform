<?php

declare(strict_types=1);

namespace App\Tests\Functional\Movement;

use Symfony\Component\HttpFoundation\JsonResponse;

class GetMovementTest extends MovementTestBase
{
    public function testGetMovement(): void
    {
        $peterMovementId = $this->getPeterMovementId();

        self::$peter->request('GET', \sprintf('%s/%s', $this->endpoint, $peterMovementId));

        $response = self::$peter->getResponse();
        $responseData = $this->getResponseData($response);

        $this->assertEquals(JsonResponse::HTTP_OK, $response->getStatusCode());
        $this->assertEquals($peterMovementId, $responseData['id']);
    }

    public function testGetGroupMovement(): void
    {
        $peterGroupMovementId = $this->getPeterGroupMovementId();

        self::$peter->request('GET', \sprintf('%s/%s', $this->endpoint, $peterGroupMovementId));

        $response = self::$peter->getResponse();
        $responseData = $this->getResponseData($response);

        $this->assertEquals(JsonResponse::HTTP_OK, $response->getStatusCode());
        $this->assertEquals($peterGroupMovementId, $responseData['id']);
    }

    public function testGetAnotherUserMovement(): void
    {
        $peterMovementId = $this->getPeterMovementId();

        self::$brian->request('GET', \sprintf('%s/%s', $this->endpoint, $peterMovementId));

        $response = self::$brian->getResponse();

        $this->assertEquals(JsonResponse::HTTP_FORBIDDEN, $response->getStatusCode());
    }

    public function testGetAnotherGroupMovement(): void
    {
        $peterGroupMovementId = $this->getPeterGroupMovementId();

        self::$brian->request('GET', \sprintf('%s/%s', $this->endpoint, $peterGroupMovementId));

        $response = self::$brian->getResponse();

        $this->assertEquals(JsonResponse::HTTP_FORBIDDEN, $response->getStatusCode());
    }
}
