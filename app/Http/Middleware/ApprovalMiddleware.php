<?php

namespace App\Http\Middleware;

use App\Role;
use Closure;
use Illuminate\Support\Facades\Gate;

class ApprovalMiddleware
{
    public function handle($request, Closure $next)
    {
        if (auth()->check()) {
            if (!auth()->user()->status) {
                auth()->logout();

                return redirect()->route('login')->with('message', 'NAN');
            }
        }

        return $next($request);
    }
}
