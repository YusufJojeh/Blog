<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class SetAuthGuard {
    public function handle( $request, Closure $next ) {
        if ( session()->has( 'auth_guard' ) ) {
            $guard = session( 'auth_guard' );
            Auth::shouldUse( $guard );
        }

        return $next( $request );
    }
}
