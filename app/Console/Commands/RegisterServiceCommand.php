<?php

namespace App\Console\Commands;

use App\Models\Service;
use Illuminate\Console\Command;

/**
 * Register your service in auth-service.
 *
 * @package App\Console\Commands
 */
class RegisterServiceCommand extends Command
{

    protected $signature = 'egal:register:service
                            {service_name : APP_SERVICE_NAME of your service that you want register}
                            {service_key : APP_SERVICE_KEY of your service}
                           ';

    protected $description = 'Register new service in auth-service';

    public function handle(): void
    {
        $serviceName = trim((string)$this->argument('service_name'));
        $serviceKey = trim((string)$this->argument('service_key'));

        $service = new Service();
        $service->id = $serviceName;
        $service->name = $serviceName;
        $service->key = $serviceKey;
        $service->saveOrFail();
    }

}
