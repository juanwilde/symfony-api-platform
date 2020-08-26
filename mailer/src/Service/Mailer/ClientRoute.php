<?php

declare(strict_types=1);

namespace Mailer\Service\Mailer;

abstract class ClientRoute
{
    public const ACTIVATE_ACCOUNT = '/activate_account';
    public const RESET_PASSWORD = '/reset_password';
    public const GROUP_REQUEST = 'group_request';
}
