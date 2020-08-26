<?php

declare(strict_types=1);

namespace App\Tests\Functional\Group;

use App\Tests\Functional\TestBase;

class GroupTestBase extends TestBase
{
    protected string $endpoint;

    public function setUp(): void
    {
        parent::setUp();

        $this->endpoint = '/api/v1/groups';
    }
}
