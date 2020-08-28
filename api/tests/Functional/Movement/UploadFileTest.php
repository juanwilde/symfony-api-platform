<?php

declare(strict_types=1);

namespace App\Tests\Functional\Movement;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\JsonResponse;

class UploadFileTest extends MovementTestBase
{
    public function testUploadFile(): void
    {
        $file = new UploadedFile(
            __DIR__.'/../../../fixtures/ticket.jpg',
            'ticket.jpg'
        );

        self::$peter->request(
            'POST',
            \sprintf('%s/%s/upload_file', $this->endpoint, $this->getPeterMovementId()),
            [],
            ['file' => $file]
        );

        $response = self::$peter->getResponse();

        $this->assertEquals(JsonResponse::HTTP_CREATED, $response->getStatusCode());
    }

    public function testUploadFileWithWrongInputName(): void
    {
        $file = new UploadedFile(
            __DIR__.'/../../../fixtures/ticket.jpg',
            'ticket.jpg'
        );

        self::$peter->request(
            'POST',
            \sprintf('%s/%s/upload_file', $this->endpoint, $this->getPeterMovementId()),
            [],
            ['non-valid-input' => $file]
        );

        $response = self::$peter->getResponse();

        $this->assertEquals(JsonResponse::HTTP_BAD_REQUEST, $response->getStatusCode());
    }
}
