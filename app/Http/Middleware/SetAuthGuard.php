<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SetAuthGuard {
    public function handle( Request $request, Closure $next ) {
        if ( session()->has( 'guard' ) ) {
            $guard = session( 'guard' );
            Auth::shouldUse( $guard );
            // Optional logging:
            logger( '👮 SetAuthGuard', [
                'guard'           => $guard,
                'user'            => optional( Auth::guard( $guard )->user() )->email,
                'is_authenticated'=> Auth::guard( $guard )->check(),
                'via_remember'    => Auth::guard( $guard )->viaRemember(),
            ] );
        }
        return $next( $request );
    }
}