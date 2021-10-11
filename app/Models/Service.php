<?php

namespace App\Models;

use Egal\AuthServiceDependencies\Models\Service as BaseService;

/**
 * @action login            {@statuses-access guest}
 * @action loginToService   {@statuses-access guest}
 */
class Service extends BaseService
{

}
