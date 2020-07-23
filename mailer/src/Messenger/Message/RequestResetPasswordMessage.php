<?php

declare(strict_types=1);

namespace Mailer\Messenger\Message;

class RequestResetPasswordMessage
{
    private string $id;
    private string $email;
    private string $resetPasswordToken;

    public function __construct(string $id, string $email, string $resetPasswordToken)
    {
        $this->id = $id;
        $this->email = $email;
        $this->resetPasswordToken = $resetPasswordToken;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getResetPasswordToken(): string
    {
        return $this->resetPasswordToken;
    }
}
