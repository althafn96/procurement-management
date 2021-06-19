<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class IsTenant
{
    public function handle(Request $request, Closure $next)
    {
        if (tenant()) {
            if (auth()->user()->role->type == 'master') {
                return back();
            } else {
                if (!auth()->user()->details) {
                    return redirect('/');
                }

                if (auth()->user()->details->tenant_id == tenant()->id) {
                    return $next($request);
                } else {
                    if (auth()->user()->details) {
                        return redirect(auth()->user()->details->tenant_id);
                    } else {
                        return redirect('/');
                    }
                }
            }
        } else {
            if (auth()->user()->role->type == 'master') {
                return $next($request);
            } else {
                if (auth()->user()->details) {
                    return redirect(auth()->user()->details->tenant_id);
                } else {
                    return redirect('/');
                }
            }
        }
    }
}
