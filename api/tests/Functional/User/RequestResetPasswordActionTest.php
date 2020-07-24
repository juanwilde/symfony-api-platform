<?php

declare(strict_types=1);

namespace App\Tests\Functional\User;

use Symfony\Component\HttpFoundation\JsonResponse;

class RequestResetPasswordActionTest extends UserTestBase
{
    public function testRequestResetPassword(): void
    {
        $payload = ['email' => 'peter@api.com'];

        self::$peter->request(
            'POST',
            \sprintf('%s/request_reset_password', $this->endpoint),
            [],
            [],
            [],
            \json_encode($payload)
        );

        $response = self::$peter->getResponse();

        $this->assertEquals(JsonResponse::HTTP_OK, $response->getStatusCode());
    }

    public function testRequestResetPasswordForNonExistingEmail(): void
    {
        $payload = ['email' => 'non-existing@api.com'];

        self::$peter->request(
            'POST',
            \sprintf('%s/request_reset_password', $this->endpoint),
            [],
            [],
            [],
            \json_encode($payload)
        );

        $response = self::$peter->getResponse();

        $this->assertEquals(JsonResponse::HTTP_NOT_FOUND, $response->getStatusCode());
    }
}
