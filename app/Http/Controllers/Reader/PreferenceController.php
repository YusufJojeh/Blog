<?php

namespace App\Http\Controllers\Reader;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

use App\Models\Preference;

class PreferenceController extends Controller {
    public function edit() {
        $reader = Auth::guard( 'reader' )->user();
        $pref = Preference::firstOrNew( [ 'reader_id'=>$reader->id ] );
        return view( 'reader.preferences', compact( 'pref' ) );
    }

    public function update( Request $request ) {
        $reader = Auth::guard( 'reader' )->user();
        $data = $request->validate( [
            'categories'=>'array',
            'email_notifications'=>'boolean'
        ] );
        $pref = Preference::updateOrCreate(
            [ 'reader_id'=>$reader->id ],
            [ 'categories'=>json_encode( $data[ 'categories' ] ?? [] ),
            'email_notifications'=>$data[ 'email_notifications' ]??false ]
        );
        return back()->with( 'success', 'Preferences saved' );
    }
}