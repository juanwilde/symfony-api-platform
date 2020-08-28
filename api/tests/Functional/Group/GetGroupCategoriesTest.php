<?php

declare(strict_types=1);

namespace App\Tests\Functional\Group;

use Symfony\Component\HttpFoundation\JsonResponse;

class GetGroupCategoriesTest extends GroupTestBase
{
    public function testGetGroupCategories(): void
    {
        self::$peter->request('GET', \sprintf('%s/%s/categories', $this->endpoint, $this->getPeterGroupId()));

        $response = self::$peter->getResponse();
        $responseData = $this->getResponseData($response);

        $this->assertEquals(JsonResponse::HTTP_OK, $response->getStatusCode());
        $this->assertCount(2, $responseData['hydra:member']);
    }

    public function testGetAnotherGroupCategories(): void
    {
        self::$brian->request('GET', \sprintf('%s/%s/categories', $this->endpoint, $this->getPeterGroupId()));

        $response = self::$brian->getResponse();
        $responseData = $this->getResponseData($response);

        $this->assertEquals(JsonResponse::HTTP_OK, $response->getStatusCode());
        $this->assertCount(0, $responseData['hydra:member']);
    }
}
