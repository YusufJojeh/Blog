<?php

namespace App\Http\Controllers\Reader;

use Illuminate\Http\Request;

class ReaderController extends Controller {
    /**
    * Display a listing of the resource.
    */

    public function index() {
        return view( 'reader.home' );
    }

 
    public function create() {
        //
    }

 

    public function store( Request $request ) {
        //
    }

    public function show( string $id ) {
        //
    }


    public function edit( string $id ) {
        //
    }

    
    public function update( Request $request, string $id ) {
        //
    }

    
    public function destroy( string $id ) {
        //
    }
}