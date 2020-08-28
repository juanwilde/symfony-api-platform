<?php

declare(strict_types=1);

namespace App\Tests\Functional\User;

use Symfony\Component\HttpFoundation\JsonResponse;

class GetUserCategoriesTest extends UserTestBase
{
    public function testGetUserCategories(): void
    {
        self::$peter->request('GET', \sprintf('%s/%s/categories', $this->endpoint, $this->getPeterId()));

        $response = self::$peter->getResponse();
        $responseData = $this->getResponseData($response);

        $this->assertEquals(JsonResponse::HTTP_OK, $response->getStatusCode());
        $this->assertCount(2, $responseData['hydra:member']);
    }

    public function testGetAnotherUserCategories(): void
    {
        self::$brian->request('GET', \sprintf('%s/%s/categories', $this->endpoint, $this->getPeterId()));

        $response = self::$brian->getResponse();
        $responseData = $this->getResponseData($response);

        $this->assertEquals(JsonResponse::HTTP_OK, $response->getStatusCode());
        $this->assertCount(0, $responseData['hydra:member']);
    }
}
