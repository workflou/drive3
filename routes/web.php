<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;

Route::get('/auth/redirect', function () {
    return Socialite::driver('google')
        ->redirect();
});

Route::get('/auth/callback', function () {
    $user = Socialite::driver('google')->user();

    $existing = User::where('email', $user->getEmail())->first();
    if ($existing) {
        $existing->update([
            'name' => $user->getName(),
            'avatar' => $user->getAvatar(),
        ]);

        Auth::login($existing);
        return redirect()->route('filament.app.tenant');
    }

    $newUser = User::create([
        'name' => $user->getName(),
        'email' => $user->getEmail(),
        'avatar' => $user->getAvatar(),
        'password' => bcrypt(\Illuminate\Support\Str::random(16)),
        'email_verified_at' => now(),
    ]);

    Auth::login($newUser);
    return redirect()->route('filament.app.tenant');
});
