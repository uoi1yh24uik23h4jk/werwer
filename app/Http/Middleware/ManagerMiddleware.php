<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ManagerMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!auth()->check()) {
            return redirect()->route('login');
        }
        
        if (!in_array(auth()->user()->role, ['admin', 'manager'])) {
            abort(403, 'Доступ запрещен');
        }
        
        return $next($request);
    }
}