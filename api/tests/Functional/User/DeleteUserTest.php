<?php

declare(strict_types=1);

namespace App\Tests\Functional\User;

use Symfony\Component\HttpFoundation\JsonResponse;

class DeleteUserTest extends UserTestBase
{
    public function testDeleteUser(): void
    {
        self::$peter->request('DELETE', \sprintf('%s/%s', $this->endpoint, $this->getPeterId()));

        $response = self::$peter->getResponse();

        $this->assertEquals(JsonResponse::HTTP_NO_CONTENT, $response->getStatusCode());
    }

    public function testDeleteAnotherUser(): void
    {
        self::$brian->request('DELETE', \sprintf('%s/%s', $this->endpoint, $this->getPeterId()));

        $response = self::$brian->getResponse();

        $this->assertEquals(JsonResponse::HTTP_FORBIDDEN, $response->getStatusCode());
    }
}
