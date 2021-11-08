<?php

namespace App\Events;

use Egal\Centrifugo\CentrifugoEvent;

class ChangedRoleEvent extends CentrifugoEvent
{
    public function broadcastOn(): array
    {
        $users = $this->entity->users()->get();
        $service = config('app.service_name');

        $channels = parent::broadcastOn();
        foreach ($users as $user) {
            $channels[] = $service . '@' . get_class_short_name($user) . '.' . $user->id;
        }

        return $channels;
    }
}
