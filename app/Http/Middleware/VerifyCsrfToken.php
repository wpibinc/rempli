<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as BaseVerifier;
use Closure;
use Illuminate\Support\Str;

class VerifyCsrfToken extends BaseVerifier
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        //
    ];
    
     public function handle($request, Closure $next)
    {
        if (Str::startsWith($request->getRequestUri(), 'some/open/route')) {
            return $next($request);
        }

        return parent::handle($request, $next);
    }
}
