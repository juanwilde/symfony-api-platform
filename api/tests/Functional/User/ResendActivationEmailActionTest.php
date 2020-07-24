<?php

declare(strict_types=1);

namespace App\Tests\Functional\User;

use Symfony\Component\HttpFoundation\JsonResponse;

class ResendActivationEmailActionTest extends UserTestBase
{
    public function testResendActivationEmail(): void
    {
        $payload = ['email' => 'roger@api.com'];

        self::$roger->request(
            'POST',
            \sprintf('%s/resend_activation_email', $this->endpoint),
            [],
            [],
            [],
            \json_encode($payload)
        );

        $response = self::$roger->getResponse();

        $this->assertEquals(JsonResponse::HTTP_OK, $response->getStatusCode());
    }

    public function testResendActivationEmailToActiveUser(): void
    {
        $payload = ['email' => 'peter@api.com'];

        self::$peter->request(
            'POST',
            \sprintf('%s/resend_activation_email', $this->endpoint),
            [],
            [],
            [],
            \json_encode($payload)
        );

        $response = self::$peter->getResponse();

        $this->assertEquals(JsonResponse::HTTP_CONFLICT, $response->getStatusCode());
    }
}
