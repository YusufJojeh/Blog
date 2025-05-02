<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;
use Illuminate\Support\Facades\Storage;

class SiteSettingsController extends Controller {

    public function index() {

        $data = [
            'site_name'   => Setting::get( 'site_name', 'My Site' ),
            'logo'        => Setting::get( 'logo' ),
            'favicon'     => Setting::get( 'favicon' ),
            'custom_css'  => Setting::get( 'custom_css' ),
        ];
        return view( 'admin.settings.index', compact( 'data' ) );
    }

    public function update( Request $request ) {

        $request->validate( [
            'site_name'  => 'required|string|max:255',
            'logo'       => 'nullable|image|max:2048',
            'favicon'    => 'nullable|image|dimensions:width=32,height=32',
            'custom_css' => 'nullable|string',
        ] );

        Setting::set( 'site_name', $request->site_name );

        if ( $request->hasFile( 'logo' ) ) {
            $path = $request->file( 'logo' )->store( 'settings', 'public' );
            Setting::set( 'logo', $path );
        }

        // favicon
        if ( $request->hasFile( 'favicon' ) ) {
            $path = $request->file( 'favicon' )->store( 'settings', 'public' );
            Setting::set( 'favicon', $path );
        }

        // custom_css
        Setting::set( 'custom_css', $request->custom_css );

        return redirect()
        ->route( 'admin.settings.index' )
        ->with( 'success', 'تم تحديث الإعدادات بنجاح.' );
    }
}
