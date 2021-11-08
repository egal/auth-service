<?php

namespace App\Events;

use Egal\Centrifugo\CentrifugoEvent;

class ChangedUserRoleEvent extends CentrifugoEvent
{
    public function broadcastOn(): array
    {
        $user = $this->entity->user()->first();
        $service = config('app.service_name');

        $channels = parent::broadcastOn();
        $channels[] = $service . '@' . get_class_short_name($user) . '.' . $user->id;

        return $channels;
    }
}
