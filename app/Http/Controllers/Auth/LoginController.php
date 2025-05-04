<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Log;
use App\Models\Admin;
use App\Models\Author;
use App\Models\Reader;

class LoginController extends Controller {
    public function showLoginForm( Request $request ) {
        // All three guards share the same view
        return view( 'auth.login' );
    }

    public function login( Request $request ) {
        $credentials = $request->only( 'email', 'password' );
        $guard       = $request->input( 'guard', 'reader' );
        $remember    = $request->has( 'remember' );

        // Pick the right model
        $model = match( $guard ) {
            'admin'  => Admin::class,
            'author' => Author::class,
            'reader' => Reader::class,
            default  => Reader::class,
        }
        ;

        // Find & verify
        $user = $model::where( 'email', $credentials[ 'email' ] )->first();
        if ( !$user || !Hash::check( $credentials[ 'password' ], $user->password ) ) {
            return back()
            ->withErrors( [ 'email'=>'المعلومات غير صحيحة.' ] )
            ->withInput( [ 'email'=>$credentials[ 'email' ] ] );
        }

        // Log in, regenerate, store guard
        Auth::guard( $guard )->login( $user, $remember );
        $request->session()->regenerate();
        session( [ 'guard'=>$guard ] );

        Log::debug( 'Redirecting to dashboard', [ 'guard'=>$guard ] );
        return redirect()->intended( "/{$guard}/dashboard" );
    }

    public function logout( Request $request ) {
        // 1 ) Get and log out the user from the correct guard
        $guard = session( 'guard', 'reader' );
        Auth::guard( $guard )->logout();

        // 2 ) Invalidate session and regenerate CSRF token
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // 3 ) Queue forget for every cookie sent in the request
        //    ( this will set a past-expiry header for each one )
        $cookieNames = array_keys( $request->cookies->all() );
        foreach ( $cookieNames as $name ) {
            Cookie::queue( Cookie::forget( $name ) );
        }

        // 4 ) Redirect back to the appropriate login page
        $loginPath = in_array( $guard, [ 'admin', 'author', 'reader' ] )
        ? "/{$guard}/login"
        : '/login';

        Log::debug( 'Logged out and cleared cookies', [ 'guard' => $guard, 'cleared' => $cookieNames ] );

        return redirect( $loginPath );
    }
}