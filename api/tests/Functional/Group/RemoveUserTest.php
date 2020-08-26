<?php

declare(strict_types=1);

namespace App\Tests\Functional\Group;

use Symfony\Component\HttpFoundation\JsonResponse;

class RemoveUserTest extends GroupTestBase
{
    public function testRemoveUserFromGroup(): void
    {
        $this->addUserToGroup();

        $payload = ['userId' => $this->getBrianId()];

        self::$peter->request(
            'PUT',
            \sprintf('%s/%s/remove_user', $this->endpoint, $this->getPeterGroupId()),
            [],
            [],
            [],
            \json_encode($payload)
        );

        $response = self::$peter->getResponse();
        $responseData = $this->getResponseData($response);

        $this->assertEquals(JsonResponse::HTTP_OK, $response->getStatusCode());
        $this->assertEquals('The user has been removed!', $responseData['message']);
    }

    public function testRemoveTheOwner(): void
    {
        $payload = ['userId' => $this->getPeterId()];

        self::$peter->request(
            'PUT',
            \sprintf('%s/%s/remove_user', $this->endpoint, $this->getPeterGroupId()),
            [],
            [],
            [],
            \json_encode($payload)
        );

        $response = self::$peter->getResponse();
        $responseData = $this->getResponseData($response);

        $this->assertEquals(JsonResponse::HTTP_CONFLICT, $response->getStatusCode());
        $this->assertEquals('Owner can not be deleted from a group. Try deleting the group instead.', $responseData['message']);
    }

    public function testRemoveNotAMember(): void
    {
        $payload = ['userId' => $this->getPeterId()];

        self::$brian->request(
            'PUT',
            \sprintf('%s/%s/remove_user', $this->endpoint, $this->getBrianGroupId()),
            [],
            [],
            [],
            \json_encode($payload)
        );

        $response = self::$brian->getResponse();
        $responseData = $this->getResponseData($response);

        $this->assertEquals(JsonResponse::HTTP_FORBIDDEN, $response->getStatusCode());
        $this->assertEquals('This user is not member of this group', $responseData['message']);
    }

    private function addUserToGroup(): void
    {
        $payload = [
            'userId' => $this->getBrianId(),
            'token' => '234567',
        ];

        self::$peter->request(
            'PUT',
            \sprintf('%s/%s/accept_request', $this->endpoint, $this->getPeterGroupId()),
            [],
            [],
            [],
            \json_encode($payload)
        );
    }
}
