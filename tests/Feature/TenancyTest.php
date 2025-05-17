<?php

use App\Enums\TeamType;
use App\Models\User;
use Filament\Facades\Filament;
use Filament\Pages\Dashboard;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\get;
use function PHPUnit\Framework\assertNull;

test('new users have a personal team', function () {
    $user = User::factory()->create();

    expect($user->teams)->toHaveCount(1);
    expect($user->teams[0]->type)->toBe(TeamType::Personal);
    expect($user->teams[0]->name)->toBe($user->name . "'s Team");
});

test('new teams have a slug', function () {
    $user = User::factory()->create([
        'name' => 'John Doe',
    ]);

    expect(str($user->teams[0]->slug)->startsWith('john-does-'))->toBe(true);
});

test('default team is saved when empty', function () {
    /**
     * @var \App\Models\User $user
     */
    $user = User::factory()->create([
        'name' => 'John Doe',
    ]);

    assertNull($team = $user->defaultTeam);

    actingAs($user);
    get(Dashboard::getUrl(tenant: $user->teams[0]))
        ->assertSuccessful();

    assertDatabaseHas('users', [
        'id' => $user->id,
        'team_id' => $user->teams[0]->id,
    ]);

    expect(Filament::getTenant()?->id)->toBe($user->teams[0]->id);
});
