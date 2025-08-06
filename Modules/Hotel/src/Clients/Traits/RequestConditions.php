<?php

declare(strict_types=1);

namespace Modules\Hotel\Clients\Traits;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;

trait RequestConditions
{
    protected function simulate(): string
    {
        Http::preventStrayRequests();

        $randomNumber = 4;

        $filePath = config('system.suppliers_files_path') . "/{$this->getName()}.json";
        $exists = File::exists($filePath);

        if (config('system.simulate_request_conditions')) {
            $randomNumber = rand(1, 4);
            sleep(rand(0, config('system.simulate_request_delay')));
        }

        if (! $exists) {
            $randomNumber = 3;
        }

        Http::fake([
            "https://{$this->getName()}.test/1" => Http::failedConnection(),
            "https://{$this->getName()}.test/2" => Http::response(null, 500),
            "https://{$this->getName()}.test/3" => Http::response([]),
            "https://{$this->getName()}.test/4" => Http::response($exists ? File::json($filePath) : []),
        ]);

        return "https://{$this->getName()}.test/{$randomNumber}";
    }
}
