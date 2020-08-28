<?php

declare(strict_types=1);

namespace App\Tests\Unit\Service\File;

use App\Service\File\FileService;
use League\Flysystem\AdapterInterface;
use League\Flysystem\FileNotFoundException;
use League\Flysystem\FilesystemInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class FileServiceTest extends TestCase
{
    /** @var FilesystemInterface|MockObject */
    private $storage;

    /** @var LoggerInterface|MockObject */
    private $logger;

    private string $mediaPath;

    private FileService $service;

    public function setUp(): void
    {
        parent::setUp();

        $this->storage = $this->getMockBuilder(FilesystemInterface::class)->disableOriginalConstructor()->getMock();
        $this->logger = $this->getMockBuilder(LoggerInterface::class)->disableOriginalConstructor()->getMock();
        $this->mediaPath = 'https://storage.com/';
        $this->service = new FileService($this->storage, $this->logger, $this->mediaPath);
    }

    public function testUploadFile(): void
    {
        $uploadedFile = $this->getMockBuilder(UploadedFile::class)->disableOriginalConstructor()->getMock();
        $uploadedFile->method('getPathname')->willReturn('/tmp');
        $uploadedFile->method('guessExtension')->willReturn('png');
        $prefix = 'avatar';

        $response = $this->service->uploadFile($uploadedFile, $prefix, AdapterInterface::VISIBILITY_PUBLIC);

        $this->assertIsString($response);
    }

    public function testValidateFile(): void
    {
        $uploadedFile = $this->getMockBuilder(UploadedFile::class)->disableOriginalConstructor()->getMock();
        $request = new Request([], [], [], [], ['avatar' => $uploadedFile]);

        $response = $this->service->validateFile($request, FileService::AVATAR_INPUT_NAME);

        $this->assertInstanceOf(UploadedFile::class, $response);
    }

    public function testValidateInvalidFile(): void
    {
        $uploadedFile = $this->getMockBuilder(UploadedFile::class)->disableOriginalConstructor()->getMock();
        $request = new Request([], [], [], [], ['file' => $uploadedFile]);

        $this->expectException(BadRequestHttpException::class);

        $this->service->validateFile($request, FileService::AVATAR_INPUT_NAME);
    }

    public function testDeleteFile(): void
    {
        $path = \sprintf('%s%s', $this->mediaPath, 'avatar/123.png');

        $this->storage
            ->expects($this->exactly(1))
            ->method('delete')
            ->with($path)
            ->willReturn(true);

        $this->service->deleteFile($path);
    }

    public function testDeleteNonExistingFile(): void
    {
        $path = \sprintf('%s%s', $this->mediaPath, 'avatar/123.png');

        $this->storage
            ->expects($this->exactly(1))
            ->method('delete')
            ->with($path)
            ->willThrowException(new FileNotFoundException($path));

        $this->logger
            ->expects($this->exactly(1))
            ->method('warning')
            ->with($this->isType('string'));

        $this->service->deleteFile($path);
    }
}
