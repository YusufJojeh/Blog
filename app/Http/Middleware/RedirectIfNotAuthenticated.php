<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfNotAuthenticated {
    public function handle( Request $request, Closure $next, $guard = null ) {
        if ( !Auth::guard( $guard )->check() ) {
            // تحديد رابط تسجيل الدخول حسب نوع المستخدم أو الرابط الحالي
            if ( $request->is( 'admin/*' ) ) {
                $loginRoute = route( 'login' );
                // تحتاج تعريف route باسم admin.login
            } elseif ( $request->is( 'writer/*' ) ) {
                $loginRoute = route( 'login' );
                // أو نفس صفحة login العامة
            } elseif ( $request->is( 'reader/*' ) ) {
                $loginRoute = route( 'login' );
            } else {
                $loginRoute = route( 'login' );
            }

            return redirect()->guest( $loginRoute );
        }

        return $next( $request );
    }
}