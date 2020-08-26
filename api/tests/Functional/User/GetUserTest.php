<?php

declare(strict_types=1);

namespace App\Tests\Functional\User;

use Symfony\Component\HttpFoundation\JsonResponse;

class GetUserTest extends UserTestBase
{
    public function testGetUser(): void
    {
        $peterId = $this->getPeterId();

        self::$peter->request('GET', \sprintf('%s/%s', $this->endpoint, $peterId));

        $response = self::$peter->getResponse();
        $responseData = $this->getResponseData($response);

        $this->assertEquals(JsonResponse::HTTP_OK, $response->getStatusCode());
        $this->assertEquals($peterId, $responseData['id']);
        $this->assertEquals('peter@api.com', $responseData['email']);
    }

    public function testGetAnotherUserData(): void
    {
        $peterId = $this->getPeterId();

        self::$brian->request('GET', \sprintf('%s/%s', $this->endpoint, $peterId));

        $response = self::$brian->getResponse();

        $this->assertEquals(JsonResponse::HTTP_FORBIDDEN, $response->getStatusCode());
    }
}
