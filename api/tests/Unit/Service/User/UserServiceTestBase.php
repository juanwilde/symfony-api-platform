<?php

declare(strict_types=1);

namespace App\Tests\Unit\Service\User;

use App\Repository\UserRepository;
use App\Service\Password\EncoderService;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Messenger\MessageBusInterface;

class UserServiceTestBase extends TestCase
{
    /** @var UserRepository|MockObject */
    protected $userRepository;

    /** @var EncoderService|MockObject */
    protected $encoderService;

    /** @var MessageBusInterface|MockObject */
    protected $messageBus;

    public function setUp(): void
    {
        parent::setUp();

        $this->userRepository = $this->getMockBuilder(UserRepository::class)->disableOriginalConstructor()->getMock();
        $this->encoderService = $this->getMockBuilder(EncoderService::class)->disableOriginalConstructor()->getMock();
        $this->messageBus = $this->getMockBuilder(MessageBusInterface::class)->disableOriginalConstructor()->getMock();
    }
}
