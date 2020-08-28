<?php

declare(strict_types=1);

namespace App\Tests\Functional\Movement;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class DownloadFileTest extends MovementTestBase
{
    public function testDownloadFile(): void
    {
        $this->getContainer()->get('default.storage')->put('example.txt', 'Some random data!');

        $payload = ['filePath' => 'example.txt'];

        self::$peter->request(
            'POST',
            \sprintf('%s/%s/download_file', $this->endpoint, $this->getPeterMovementId()),
            [],
            [],
            [],
            \json_encode($payload)
        );

        $response = self::$peter->getResponse();

        $this->assertEquals(JsonResponse::HTTP_OK, $response->getStatusCode());
        $this->assertInstanceOf(Response::class, $response);
    }

    public function testDownloadAnotherUserFile(): void
    {
        $this->getContainer()->get('default.storage')->put('example.txt', 'Some random data!');

        $payload = ['filePath' => 'example.txt'];

        self::$brian->request(
            'POST',
            \sprintf('%s/%s/download_file', $this->endpoint, $this->getPeterMovementId()),
            [],
            [],
            [],
            \json_encode($payload)
        );

        $response = self::$brian->getResponse();

        $this->assertEquals(JsonResponse::HTTP_FORBIDDEN, $response->getStatusCode());
    }

    public function testDownloadNonExistingFile(): void
    {
        $this->getContainer()->get('default.storage')->put('example.txt', 'Some random data!');

        $payload = ['filePath' => 'non-existing-file.txt'];

        self::$peter->request(
            'POST',
            \sprintf('%s/%s/download_file', $this->endpoint, $this->getPeterMovementId()),
            [],
            [],
            [],
            \json_encode($payload)
        );

        $response = self::$peter->getResponse();

        $this->assertEquals(JsonResponse::HTTP_NOT_FOUND, $response->getStatusCode());
    }
}
