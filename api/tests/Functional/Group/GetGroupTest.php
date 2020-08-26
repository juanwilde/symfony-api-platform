<?php

declare(strict_types=1);

namespace App\Tests\Functional\Group;

use Symfony\Component\HttpFoundation\JsonResponse;

class GetGroupTest extends GroupTestBase
{
    public function testGetGroup(): void
    {
        $peterGroupId = $this->getPeterGroupId();

        self::$peter->request('GET', \sprintf('%s/%s', $this->endpoint, $peterGroupId));

        $response = self::$peter->getResponse();
        $responseData = $this->getResponseData($response);

        $this->assertEquals(JsonResponse::HTTP_OK, $response->getStatusCode());
        $this->assertEquals($peterGroupId, $responseData['id']);
    }

    public function testGetAnotherGroupData(): void
    {
        $peterGroupId = $this->getPeterGroupId();

        self::$brian->request('GET', \sprintf('%s/%s', $this->endpoint, $peterGroupId));

        $response = self::$brian->getResponse();

        $this->assertEquals(JsonResponse::HTTP_FORBIDDEN, $response->getStatusCode());
    }
}
