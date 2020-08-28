<?php

declare(strict_types=1);

namespace App\Tests\Functional\Category;

use Symfony\Component\HttpFoundation\JsonResponse;

class UpdateCategoryTest extends CategoryTestBase
{
    public function testUpdateCategory(): void
    {
        $payload = ['name' => 'New Category Name'];

        self::$peter->request(
            'PUT',
            \sprintf('%s/%s', $this->endpoint, $this->getPeterExpenseCategoryId()),
            [],
            [],
            [],
            \json_encode($payload)
        );

        $response = self::$peter->getResponse();
        $responseData = $this->getResponseData($response);

        $this->assertEquals(JsonResponse::HTTP_OK, $response->getStatusCode());
        $this->assertEquals($payload['name'], $responseData['name']);
    }

    public function testUpdateGroupCategory(): void
    {
        $payload = ['name' => 'New Category Name'];

        self::$peter->request(
            'PUT',
            \sprintf('%s/%s', $this->endpoint, $this->getPeterGroupExpenseCategoryId()),
            [],
            [],
            [],
            \json_encode($payload)
        );

        $response = self::$peter->getResponse();
        $responseData = $this->getResponseData($response);

        $this->assertEquals(JsonResponse::HTTP_OK, $response->getStatusCode());
        $this->assertEquals($payload['name'], $responseData['name']);
    }

    public function testUpdateAnotherUserCategory(): void
    {
        $payload = ['name' => 'New Category Name'];

        self::$brian->request(
            'PUT',
            \sprintf('%s/%s', $this->endpoint, $this->getPeterExpenseCategoryId()),
            [],
            [],
            [],
            \json_encode($payload)
        );

        $response = self::$brian->getResponse();

        $this->assertEquals(JsonResponse::HTTP_FORBIDDEN, $response->getStatusCode());
    }

    public function testUpdateAnotherGroupCategory(): void
    {
        $payload = ['name' => 'New Category Name'];

        self::$brian->request(
            'PUT',
            \sprintf('%s/%s', $this->endpoint, $this->getPeterGroupExpenseCategoryId()),
            [],
            [],
            [],
            \json_encode($payload)
        );

        $response = self::$brian->getResponse();

        $this->assertEquals(JsonResponse::HTTP_FORBIDDEN, $response->getStatusCode());
    }
}
