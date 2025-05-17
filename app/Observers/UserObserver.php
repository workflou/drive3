<?php

namespace App\Observers;

use App\Enums\TeamRole;
use App\Enums\TeamType;
use App\Models\User;

class UserObserver
{
    public function created(User $user): void
    {
        $user->teams()->create([
            'name' => $user->name . "'s Team",
            'type' => TeamType::Personal,
        ], [
            'role' => TeamRole::Owner,
        ]);
    }
}
