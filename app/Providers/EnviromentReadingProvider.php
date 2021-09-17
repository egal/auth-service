<?php

declare(strict_types=1);

namespace App\Providers;

use App\Exceptions\IncorrectAppServicesEnvironmentVariablePatternException;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;

class EnviromentReadingProvider extends ServiceProvider
{

    public function register()
    {
        $services = [];
        $services[config('app.service_name')] = ['key' => config('app.service_key')];
        $env = env('APP_SERVICES');

        if ($env) {
            foreach (explode(',', $env) as $service) {
                if (!preg_match('/^(\w+):(.+)$/', $service, $matches)) {
                    throw IncorrectAppServicesEnvironmentVariablePatternException::make($service);
                }

                $services[$matches[1]] = ['key' => $matches[2]];
            }
        }

        Config::set('app.services', $services);
    }

}
