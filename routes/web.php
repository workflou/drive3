<?php

use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;

Route::get('/auth/redirect', function () {
    return Socialite::driver('google')
        ->scopes([])
        ->redirect();
});

Route::get('/auth/callback', function () {
    $user = Socialite::driver('google')->user();

    dd($user);
});
