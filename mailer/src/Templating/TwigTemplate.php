<?php

declare(strict_types=1);

namespace Mailer\Templating;

abstract class TwigTemplate
{
    public const USER_REGISTER = 'user/register.twig';
    public const REQUEST_RESET_PASSWORD = 'user/request-reset-password.twig';
    public const GROUP_REQUEST = 'group/group-request.twig';
}
