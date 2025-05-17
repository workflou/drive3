<?php

namespace App\Observers;

use App\Models\Team;

class TeamObserver
{
    public function creating(Team $team): void
    {
        $team->slug = str(str($team->name)->slug() . '-' . str()->random(16))->slug();
    }
}
