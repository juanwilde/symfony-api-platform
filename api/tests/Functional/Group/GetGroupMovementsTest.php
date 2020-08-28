<?php

declare(strict_types=1);

namespace App\Tests\Functional\Group;

use Symfony\Component\HttpFoundation\JsonResponse;

class GetGroupMovementsTest extends GroupTestBase
{
    public function testGetGroupMovements(): void
    {
        self::$peter->request('GET', \sprintf('%s/%s/movements', $this->endpoint, $this->getPeterGroupId()));

        $response = self::$peter->getResponse();
        $responseData = $this->getResponseData($response);

        $this->assertEquals(JsonResponse::HTTP_OK, $response->getStatusCode());
        $this->assertCount(1, $responseData['hydra:member']);
    }

    public function testGetAnotherGroupMovements(): void
    {
        self::$brian->request('GET', \sprintf('%s/%s/movements', $this->endpoint, $this->getPeterGroupId()));

        $response = self::$brian->getResponse();
        $responseData = $this->getResponseData($response);

        $this->assertEquals(JsonResponse::HTTP_OK, $response->getStatusCode());
        $this->assertCount(0, $responseData['hydra:member']);
    }
}
