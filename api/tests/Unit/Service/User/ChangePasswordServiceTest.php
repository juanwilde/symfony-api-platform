<?php

declare(strict_types=1);

namespace App\Tests\Unit\Service\User;

use App\Entity\User;
use App\Exception\Password\PasswordException;
use App\Service\User\ChangePasswordService;

class ChangePasswordServiceTest extends UserServiceTestBase
{
    private ChangePasswordService $service;

    public function setUp(): void
    {
        parent::setUp();

        $this->service = new ChangePasswordService($this->userRepository, $this->encoderService);
    }

    public function testChangePassword(): void
    {
        $user = new User('name', 'name@api.com');
        $oldPassword = 'old-password';
        $newPassword = 'new-password';

        $this->userRepository
            ->expects($this->exactly(1))
            ->method('findOneByIdOrFail')
            ->with($this->isType('string'))
            ->willReturn($user);

        $this->encoderService
            ->expects($this->exactly(1))
            ->method('isValidPassword')
            ->with($user, $oldPassword)
            ->willReturn(true);

        $user = $this->service->changePassword($user->getId(), $oldPassword, $newPassword);

        $this->assertInstanceOf(User::class, $user);
    }

    public function testChangePasswordForInvalidOldPassword(): void
    {
        $user = new User('name', 'name@api.com');
        $oldPassword = 'old-password';
        $newPassword = 'new-password';

        $this->userRepository
            ->expects($this->exactly(1))
            ->method('findOneByIdOrFail')
            ->with($this->isType('string'))
            ->willReturn($user);

        $this->encoderService
            ->expects($this->exactly(1))
            ->method('isValidPassword')
            ->with($user, $oldPassword)
            ->willReturn(false);

        $this->expectException(PasswordException::class);

        $this->service->changePassword($user->getId(), $oldPassword, $newPassword);
    }
}
