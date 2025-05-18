<?php

use App\Filament\Resources\Drives\DriveResource;
use App\Filament\Resources\Drives\Pages\ListDrives;
use App\Models\Drive;
use App\Models\Team;
use App\Models\User;
use Livewire\Livewire;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\get;

test('guests cannot access drives', function () {
    $team = Team::factory()->create();

    get(DriveResource::getUrl('index', ['tenant' => $team]))
        ->assertRedirect(route('filament.app.auth.login'));
});

test('users without access to the team cannot access drives', function () {
    $team = Team::factory()->create();

    /**
     * @var \App\Models\User $user
     */
    $user = User::factory()->create();

    actingAs($user);
    get(DriveResource::getUrl('index', ['tenant' => $team]))
        ->assertNotFound();
});

test('user can see team\'s drives', function () {
    /**
     * @var \App\Models\User $user
     */
    $user = User::factory()->create();
    $drive = Drive::factory()->for($user->teams()->first())->create([
        'name' => 'Test Drive',
    ]);

    actingAs($user);
    get(DriveResource::getUrl('index', ['tenant' => $user->teams()->first()]))
        ->assertSuccessful();

    Livewire::test(ListDrives::class, ['tenant' => $user->teams()->first()])
        ->assertSee($drive->name);
});
