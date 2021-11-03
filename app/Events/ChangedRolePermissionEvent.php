<?php

namespace App\Events;

use Egal\Centrifugo\CentrifugoEvent;

class ChangedRolePermissionEvent extends CentrifugoEvent
{
    public function broadcastOn(): array
    {
        $user = $this->entity->user()->first();
        $service = config('app.service_name');

        $channels = parent::broadcastOn();
        $parentEntityChannel = $service . '@' . get_class_short_name($user) . '.' . $user->id;
        $channels[] = $parentEntityChannel;

        return $channels;
    }
}
