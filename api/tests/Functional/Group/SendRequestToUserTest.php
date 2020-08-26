<?php

declare(strict_types=1);

namespace App\Tests\Functional\Group;

use Symfony\Component\HttpFoundation\JsonResponse;

class SendRequestToUserTest extends GroupTestBase
{
    public function testSendRequestToUser(): void
    {
        $payload = ['email' => 'roger@api.com'];

        self::$peter->request(
            'PUT',
            \sprintf('%s/%s/send_request', $this->endpoint, $this->getPeterGroupId()),
            [],
            [],
            [],
            \json_encode($payload)
        );

        $response = self::$peter->getResponse();
        $responseData = $this->getResponseData($response);

        $this->assertEquals(JsonResponse::HTTP_OK, $response->getStatusCode());
        $this->assertEquals('The request has been sent!', $responseData['message']);
    }

    public function testSendAnotherGroupRequestToUser(): void
    {
        $payload = ['email' => 'roger@api.com'];

        self::$brian->request(
            'PUT',
            \sprintf('%s/%s/send_request', $this->endpoint, $this->getPeterGroupId()),
            [],
            [],
            [],
            \json_encode($payload)
        );

        $response = self::$brian->getResponse();
        $responseData = $this->getResponseData($response);

        $this->assertEquals(JsonResponse::HTTP_FORBIDDEN, $response->getStatusCode());
        $this->assertEquals('You are not the owner of this group', $responseData['message']);
    }

    public function testSendRequestToAnAlreadyMember(): void
    {
        $payload = ['email' => 'peter@api.com'];

        self::$peter->request(
            'PUT',
            \sprintf('%s/%s/send_request', $this->endpoint, $this->getPeterGroupId()),
            [],
            [],
            [],
            \json_encode($payload)
        );

        $response = self::$peter->getResponse();
        $responseData = $this->getResponseData($response);

        $this->assertEquals(JsonResponse::HTTP_CONFLICT, $response->getStatusCode());
        $this->assertEquals('This user is already member of the group', $responseData['message']);
    }
}
