<?php

use App\Order;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('Notification_To_.{id}', function ($user) {
    return true;
});

Broadcast::channel('Online', function ($user) {
    return ['id' => $user->id, 'name' => $user->name];
});