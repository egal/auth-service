<?php

namespace App\Events;

use Egal\Centrifugo\CentrifugoEvent;

class ChangedUserRoleEvent extends CentrifugoEvent
{
    public function broadcastOn(): array
    {

    }
}
