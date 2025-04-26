<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller {
    public function showLoginForm() {
        return view( 'auth.login' );
    }

    public function login( Request $request ) {
        $credentials = $request->only( 'email', 'password' );

        foreach ( [ 'admin', 'author', 'reader' ] as $guard ) {
            if ( Auth::guard( $guard )->attempt( $credentials ) ) {
                $request->session()->regenerate();

                // حفظ اسم الجارد في الجلسة
                session( [ 'auth_guard' => $guard ] );

                return redirect()->intended( "/$guard/dashboard" );
            }
        }

        return back()->withErrors( [
            'email' => 'المعلومات غير صحيحة.',
        ] )->onlyInput( 'email' );
    }

    public function logout( Request $request ) {
        $guard = session( 'auth_guard' );

        if ( $guard && Auth::guard( $guard )->check() ) {
            Auth::guard( $guard )->logout();
        }

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect( '/login' );
    }
}