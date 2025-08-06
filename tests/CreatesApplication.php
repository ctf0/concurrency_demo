<?php

declare(strict_types=1);

namespace Tests;

use Illuminate\Contracts\Console\Kernel;
use Illuminate\Foundation\Application;

trait CreatesApplication
{
    public function createApplication(): Application
    {
        $app = require __DIR__ . '/../bootstrap/app.php';

        // Ensure the console kernel boots the application for tests
        $app->make(Kernel::class)->bootstrap();

        return $app;
    }
}
