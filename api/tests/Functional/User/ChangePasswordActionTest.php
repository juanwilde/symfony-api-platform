<?php

declare(strict_types=1);

namespace App\Tests\Functional\User;

use Symfony\Component\HttpFoundation\JsonResponse;

class ChangePasswordActionTest extends UserTestBase
{
    public function testChangePassword(): void
    {
        $payload = [
            'oldPassword' => 'password',
            'newPassword' => 'new-password',
        ];

        self::$peter->request(
            'PUT',
            \sprintf('%s/%s/change_password', $this->endpoint, $this->getPeterId()),
            [],
            [],
            [],
            \json_encode($payload)
        );

        $response = self::$peter->getResponse();

        $this->assertEquals(JsonResponse::HTTP_OK, $response->getStatusCode());
    }

    public function testChangePasswordWithInvalidOldPassword(): void
    {
        $payload = [
            'oldPassword' => 'non-a-good-one',
            'newPassword' => 'new-password',
        ];

        self::$peter->request(
            'PUT',
            \sprintf('%s/%s/change_password', $this->endpoint, $this->getPeterId()),
            [],
            [],
            [],
            \json_encode($payload)
        );

        $response = self::$peter->getResponse();

        $this->assertEquals(JsonResponse::HTTP_BAD_REQUEST, $response->getStatusCode());
    }
}
