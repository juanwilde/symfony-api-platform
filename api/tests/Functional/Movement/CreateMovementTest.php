<?php

declare(strict_types=1);

namespace App\Tests\Functional\Movement;

use Symfony\Component\HttpFoundation\JsonResponse;

class CreateMovementTest extends MovementTestBase
{
    public function testCreateMovement(): void
    {
        $payload = [
            'category' => \sprintf('/api/v1/categories/%s', $this->getPeterExpenseCategoryId()),
            'owner' => \sprintf('/api/v1/users/%s', $this->getPeterId()),
            'amount' => 120.50,
        ];

        self::$peter->request('POST', $this->endpoint, [], [], [], \json_encode($payload));

        $response = self::$peter->getResponse();
        $responseData = $this->getResponseData($response);

        $this->assertEquals(JsonResponse::HTTP_CREATED, $response->getStatusCode());
        $this->assertEquals($payload['category'], $responseData['category']['@id']);
        $this->assertEquals($payload['owner'], $responseData['owner']['@id']);
        $this->assertEquals($payload['amount'], $responseData['amount']);
        $this->assertNull($responseData['group']);
    }

    public function testCreateMovementWithAnotherUserCategory(): void
    {
        $payload = [
            'category' => \sprintf('/api/v1/categories/%s', $this->getBrianExpenseCategoryId()),
            'owner' => \sprintf('/api/v1/users/%s', $this->getPeterId()),
            'amount' => 120.50,
        ];

        self::$peter->request('POST', $this->endpoint, [], [], [], \json_encode($payload));

        $response = self::$peter->getResponse();

        $this->assertEquals(JsonResponse::HTTP_FORBIDDEN, $response->getStatusCode());
    }

    public function testCreateMovementForAnotherUser(): void
    {
        $payload = [
            'category' => \sprintf('/api/v1/categories/%s', $this->getPeterExpenseCategoryId()),
            'owner' => \sprintf('/api/v1/users/%s', $this->getBrianId()),
            'amount' => 120.50,
        ];

        self::$peter->request('POST', $this->endpoint, [], [], [], \json_encode($payload));

        $response = self::$peter->getResponse();

        $this->assertEquals(JsonResponse::HTTP_FORBIDDEN, $response->getStatusCode());
    }

    public function testCreateMovementWithInvalidAmount(): void
    {
        $payload = [
            'category' => \sprintf('/api/v1/categories/%s', $this->getPeterExpenseCategoryId()),
            'owner' => \sprintf('/api/v1/users/%s', $this->getPeterId()),
            'amount' => 'abc',
        ];

        self::$peter->request('POST', $this->endpoint, [], [], [], \json_encode($payload));

        $response = self::$peter->getResponse();

        $this->assertEquals(JsonResponse::HTTP_BAD_REQUEST, $response->getStatusCode());
    }

    public function testCreateGroupMovement(): void
    {
        $payload = [
            'category' => \sprintf('/api/v1/categories/%s', $this->getPeterGroupExpenseCategoryId()),
            'owner' => \sprintf('/api/v1/users/%s', $this->getPeterId()),
            'group' => \sprintf('/api/v1/groups/%s', $this->getPeterGroupId()),
            'amount' => 300,
        ];

        self::$peter->request('POST', $this->endpoint, [], [], [], \json_encode($payload));

        $response = self::$peter->getResponse();
        $responseData = $this->getResponseData($response);

        $this->assertEquals(JsonResponse::HTTP_CREATED, $response->getStatusCode());
        $this->assertEquals($payload['category'], $responseData['category']['@id']);
        $this->assertEquals($payload['owner'], $responseData['owner']['@id']);
        $this->assertEquals($payload['amount'], $responseData['amount']);
        $this->assertEquals($payload['group'], $responseData['group']['@id']);
    }

    public function testCreateMovementToAnotherGroup(): void
    {
        $payload = [
            'category' => \sprintf('/api/v1/categories/%s', $this->getPeterGroupExpenseCategoryId()),
            'owner' => \sprintf('/api/v1/users/%s', $this->getPeterId()),
            'group' => \sprintf('/api/v1/groups/%s', $this->getBrianGroupId()),
            'amount' => 300,
        ];

        self::$peter->request('POST', $this->endpoint, [], [], [], \json_encode($payload));

        $response = self::$peter->getResponse();

        $this->assertEquals(JsonResponse::HTTP_FORBIDDEN, $response->getStatusCode());
    }

    public function testCreateGroupMovementWithUserCategory(): void
    {
        $payload = [
            'category' => \sprintf('/api/v1/categories/%s', $this->getPeterExpenseCategoryId()),
            'owner' => \sprintf('/api/v1/users/%s', $this->getPeterId()),
            'group' => \sprintf('/api/v1/groups/%s', $this->getPeterGroupId()),
            'amount' => 300,
        ];

        self::$peter->request('POST', $this->endpoint, [], [], [], \json_encode($payload));

        $response = self::$peter->getResponse();

        $this->assertEquals(JsonResponse::HTTP_FORBIDDEN, $response->getStatusCode());
    }

    public function testCreateGroupMovementWithAnotherGroupCategory(): void
    {
        $payload = [
            'category' => \sprintf('/api/v1/categories/%s', $this->getBrianGroupExpenseCategoryId()),
            'owner' => \sprintf('/api/v1/users/%s', $this->getPeterId()),
            'group' => \sprintf('/api/v1/groups/%s', $this->getPeterGroupId()),
            'amount' => 300,
        ];

        self::$peter->request('POST', $this->endpoint, [], [], [], \json_encode($payload));

        $response = self::$peter->getResponse();

        $this->assertEquals(JsonResponse::HTTP_FORBIDDEN, $response->getStatusCode());
    }
}
