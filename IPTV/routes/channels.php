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

Broadcast::channel('Notification_To_.{id}', function () {
    return true;
});

Broadcast::channel('ClientSettings', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

