<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;

class EnsureEmailIsVerified
{
    public function handle($request, Closure $next, $redirectToRoute = null)
    {
        $user = $request->user();

        Log::info('EnsureEmailIsVerified Middleware Executed', ['user' => $user]);

        if (!$user) {
            return $next($request);
        }

        if ($user && !$user->hasVerifiedEmail()) {
            Log::info('User email not verified', ['user' => $user]);
            return $request->expectsJson()
                ? abort(403, 'Your email address is not verified.')
                : Redirect::route($redirectToRoute ?: 'verification.notice');
        }

        Log::info('User authenticated and verified', ['user' => $user]);
        return $next($request);
    }
}
