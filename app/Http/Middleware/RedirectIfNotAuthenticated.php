<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class RedirectIfNotAuthenticated {
    public function handle( Request $request, Closure $next, $guard = null ) {
        $guard = $guard ?: 'reader';

        if ( ! Auth::guard( $guard )->check() ) {
            $loginRoute = in_array( $guard, [ 'admin', 'author', 'reader' ] )
            ? route( "{$guard}.login" )
            : route( 'login' );
            return redirect()->guest( $loginRoute );
        }

        if ( Auth::guard( $guard )->viaRemember() ) {
            Log::info( '✅ via remember me', [ 'guard'=>$guard, 'email'=>Auth::guard( $guard )->user()->email ] );
        }

        return $next( $request );
    }
}