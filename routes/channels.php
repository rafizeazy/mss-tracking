<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('mss-updates', function ($user) {
    $role = $user->role instanceof \App\Enums\Role ? $user->role->value : strtolower($user->role);
    return $role !== 'customer';
});
