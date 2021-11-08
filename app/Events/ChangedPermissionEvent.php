<?php

namespace App\Events;

use Egal\Centrifugo\CentrifugoEvent;

class ChangedPermissionEvent extends CentrifugoEvent
{
    public function broadcastOn(): array
    {
        $roles = $this->entity->roles()->first();
        foreach ($roles as $role) {
            ChangedRoleEvent::dispatch($role);
        }
        return parent::broadcastOn();
    }
}
