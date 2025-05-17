<?php

namespace App\Models;

use App\Enums\TeamRole;
use Illuminate\Database\Eloquent\Relations\Pivot;

class TeamUser extends Pivot
{
    protected $fillable = [
        'user_id',
        'team_id',
        'role',
    ];

    protected $casts = [
        'role' => TeamRole::class,
    ];
}
