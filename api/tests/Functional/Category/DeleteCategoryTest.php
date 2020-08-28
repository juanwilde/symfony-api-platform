<?php

declare(strict_types=1);

namespace App\Tests\Functional\Category;

use Symfony\Component\HttpFoundation\JsonResponse;

class DeleteCategoryTest extends CategoryTestBase
{
    public function testDeleteCategory(): void
    {
        self::$peter->request('DELETE', \sprintf('%s/%s', $this->endpoint, $this->getPeterExpenseCategoryId()));

        $response = self::$peter->getResponse();

        $this->assertEquals(JsonResponse::HTTP_NO_CONTENT, $response->getStatusCode());
    }

    public function testDeleteGroupCategory(): void
    {
        self::$peter->request('DELETE', \sprintf('%s/%s', $this->endpoint, $this->getPeterGroupExpenseCategoryId()));

        $response = self::$peter->getResponse();

        $this->assertEquals(JsonResponse::HTTP_NO_CONTENT, $response->getStatusCode());
    }

    public function testDeleteAnotherUserCategory(): void
    {
        self::$brian->request('DELETE', \sprintf('%s/%s', $this->endpoint, $this->getPeterExpenseCategoryId()));

        $response = self::$brian->getResponse();

        $this->assertEquals(JsonResponse::HTTP_FORBIDDEN, $response->getStatusCode());
    }

    public function testDeleteAnotherGroupCategory(): void
    {
        self::$brian->request('DELETE', \sprintf('%s/%s', $this->endpoint, $this->getPeterGroupExpenseCategoryId()));

        $response = self::$brian->getResponse();

        $this->assertEquals(JsonResponse::HTTP_FORBIDDEN, $response->getStatusCode());
    }
}
