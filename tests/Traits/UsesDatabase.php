<?php

declare(strict_types=1);

namespace Tests\Traits;

use Illuminate\Foundation\Testing\RefreshDatabase;

trait UsesDatabase
{
    use RefreshDatabase {
        refreshTestDatabase as parentRefreshTestDatabase;
    }
}
