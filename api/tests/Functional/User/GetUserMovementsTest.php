<?php

declare(strict_types=1);

namespace App\Tests\Functional\User;

use Symfony\Component\HttpFoundation\JsonResponse;

class GetUserMovementsTest extends UserTestBase
{
    public function testGetUserMovements(): void
    {
        self::$peter->request('GET', \sprintf('%s/%s/movements', $this->endpoint, $this->getPeterId()));

        $response = self::$peter->getResponse();
        $responseData = $this->getResponseData($response);

        $this->assertEquals(JsonResponse::HTTP_OK, $response->getStatusCode());
        $this->assertCount(1, $responseData['hydra:member']);
    }

    public function testGetAnotherUserMovements(): void
    {
        self::$brian->request('GET', \sprintf('%s/%s/movements', $this->endpoint, $this->getPeterId()));

        $response = self::$brian->getResponse();
        $responseData = $this->getResponseData($response);

        $this->assertEquals(JsonResponse::HTTP_OK, $response->getStatusCode());
        $this->assertCount(0, $responseData['hydra:member']);
    }
}
