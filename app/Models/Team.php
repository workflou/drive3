<?php

namespace App\Models;

use App\Enums\TeamType;
use App\Observers\TeamObserver;
use Filament\Models\Contracts\HasCurrentTenantLabel;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[ObservedBy(TeamObserver::class)]
class Team extends Model implements HasCurrentTenantLabel
{
    /** @use HasFactory<\Database\Factories\TeamFactory> */
    use HasFactory;

    protected $fillable = [
        'slug',
        'name',
        'type',
    ];

    protected $casts = [
        'type' => TeamType::class,
    ];

    public function getCurrentTenantLabel(): string
    {
        return $this->type->getLabel();
    }
}
