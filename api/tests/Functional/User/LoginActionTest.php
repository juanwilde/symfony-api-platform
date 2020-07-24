<?php

declare(strict_types=1);

namespace App\Tests\Functional\User;

use Lexik\Bundle\JWTAuthenticationBundle\Response\JWTAuthenticationFailureResponse;
use Lexik\Bundle\JWTAuthenticationBundle\Response\JWTAuthenticationSuccessResponse;
use Symfony\Component\HttpFoundation\JsonResponse;

class LoginActionTest extends UserTestBase
{
    public function testLogin(): void
    {
        $payload = [
            'username' => 'peter@api.com',
            'password' => 'password',
        ];

        self::$peter->request('POST', \sprintf('%s/login_check', $this->endpoint), [], [], [], \json_encode($payload));

        $response = self::$peter->getResponse();

        $this->assertEquals(JsonResponse::HTTP_OK, $response->getStatusCode());
        $this->assertInstanceOf(JWTAuthenticationSuccessResponse::class, $response);
    }

    public function testLoginWithInvalidCredentials(): void
    {
        $payload = [
            'username' => 'peter@api.com',
            'password' => 'invalid-password',
        ];

        self::$peter->request('POST', \sprintf('%s/login_check', $this->endpoint), [], [], [], \json_encode($payload));

        $response = self::$peter->getResponse();

        $this->assertEquals(JsonResponse::HTTP_UNAUTHORIZED, $response->getStatusCode());
        $this->assertInstanceOf(JWTAuthenticationFailureResponse::class, $response);
    }
}
