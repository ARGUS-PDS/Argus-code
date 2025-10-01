<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ForcePortugueseLocale
{
    public function handle($request, Closure $next)
    {
        app()->setLocale('pt_BR');
        session()->put('locale', 'pt_BR');
        return $next($request);
    }
}