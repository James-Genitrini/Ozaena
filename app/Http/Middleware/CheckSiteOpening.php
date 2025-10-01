<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class CheckSiteOpening
{
    public function handle(Request $request, Closure $next)
    {
        $openingDate = Carbon::parse(config('app.opening_date'));
        $now = Carbon::now();

        // Si la date n'est pas encore arrivée
        if ($now->lt($openingDate)) {
            // On laisse passer uniquement la route "coming-soon"
            if (!$request->is('coming-soon')) {
                return redirect()->route('coming-soon');
            }
        }

        return $next($request);
    }
}