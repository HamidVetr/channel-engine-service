<?php

declare(strict_types=1);

namespace Tests\Integration;

use Illuminate\Foundation\Testing\TestCase;
use Tests\Traits\CreatesApplication;
use Tests\Traits\UsesDatabase;

abstract class AbstractIntegrationTestCase extends TestCase
{
    use CreatesApplication;
    use UsesDatabase;
}
