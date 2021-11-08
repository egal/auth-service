<?php

namespace App\Events;

use Egal\Centrifugo\CentrifugoEvent;

class ChangedRolePermissionEvent extends CentrifugoEvent
{
    public function broadcastOn(): array
    {
        $role = $this->entity->role()->first();

        ChangedRoleEvent::dispatch($role);

        return parent::broadcastOn();
    }
}
