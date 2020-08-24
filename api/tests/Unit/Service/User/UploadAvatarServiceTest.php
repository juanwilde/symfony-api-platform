<?php

declare(strict_types=1);

namespace App\Tests\Unit\Service\User;

use App\Entity\User;
use App\Repository\UserRepository;
use App\Service\File\FileService;
use App\Service\User\UploadAvatarService;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;

class UploadAvatarServiceTest extends TestCase
{
    /** @var UserRepository|MockObject */
    private $userRepository;

    /** @var FileService|MockObject */
    private $fileService;

    private string $mediaPath;

    private UploadAvatarService $service;

    public function setUp(): void
    {
        parent::setUp();

        $this->userRepository = $this->getMockBuilder(UserRepository::class)->disableOriginalConstructor()->getMock();
        $this->fileService = $this->getMockBuilder(FileService::class)->disableOriginalConstructor()->getMock();
        $this->mediaPath = 'https://storage.com/';
        $this->service = new UploadAvatarService($this->userRepository, $this->fileService, $this->mediaPath);
    }

    public function testUploadAvatar(): void
    {
        $request = $this->getMockBuilder(Request::class)->disableOriginalConstructor()->getMock();
        $file = $this->getMockBuilder(UploadedFile::class)->disableOriginalConstructor()->getMock();
        $user = new User('name', 'user@api.com');
        $user->setAvatar('abc.png');

        $this->fileService
            ->expects($this->exactly(1))
            ->method('validateFile')
            ->with($request, FileService::AVATAR_INPUT_NAME)
            ->willReturn($file);

        $this->fileService
            ->expects($this->exactly(1))
            ->method('deleteFile')
            ->with($user->getAvatar());

        $this->fileService
            ->expects($this->exactly(1))
            ->method('uploadFile')
            ->with($file, FileService::AVATAR_INPUT_NAME)
            ->willReturn('aaa.png');

        $response = $this->service->uploadAvatar($request, $user);

        $this->assertInstanceOf(User::class, $response);
        $this->assertEquals('aaa.png', $response->getAvatar());
    }
}
