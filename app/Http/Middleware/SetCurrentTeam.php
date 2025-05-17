<?php

namespace App\Http\Middleware;

use Closure;
use Filament\Facades\Filament;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetCurrentTeam
{
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->user() && !$request->user()->team_id && $team = $request->user()->teams()->first()) {
            $request->user()->team_id = $team->id;
            $request->user()->saveQuietly();

            Filament::setTenant($team);
        }

        return $next($request);
    }
}
