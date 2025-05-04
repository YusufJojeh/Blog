<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class ProfileController extends Controller {

    public function show( Request $request ) {
        $guard = $request->segment( 1 );

        if ( ! in_array( $guard, [ 'admin', 'author', 'reader' ] ) ) {
            abort( 404 );
        }

        Auth::shouldUse( $guard );

        $user = Auth::guard( $guard )->user();

        return view( 'profile', compact( 'user', 'guard' ) );
    }

    public function update( Request $request ) {

        $guard = $request->segment( 1 );
        if ( ! in_array( $guard, [ 'admin', 'author', 'reader' ] ) ) {
            abort( 404 );
        }
        Auth::shouldUse( $guard );
        $user = Auth::guard( $guard )->user();

        $data = $request->validate( [
            'name'           => [ 'required', 'string', 'max:255' ],
            'email'          => [
                'required', 'email',
                Rule::unique( "{$guard}s", 'email' )->ignore( $user->id ),
            ],
            'password'       => [ 'nullable', 'confirmed', 'min:8' ],
            'profile_image'  => [ 'nullable', 'image', 'max:2048' ],
        ] );

        $updates = [
            'name'  => $data[ 'name' ],
            'email' => $data[ 'email' ],
        ];

        if ( ! empty( $data[ 'password' ] ) ) {
            $updates[ 'password' ] = Hash::make( $data[ 'password' ] );
        }

        if ( $request->hasFile( 'profile_image' ) ) {
            $updates[ 'profile_image' ] =
            $request->file( 'profile_image' )
            ->store( 'profiles', 'public' );
        }

        $user->update( $updates );

        return back()->with( 'success', 'Profile updated successfully' );
    }
}