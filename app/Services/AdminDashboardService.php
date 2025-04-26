<?php

namespace App\Services;

use App\Models\Admin;
use App\Models\Author;
use App\Models\Reader;
use Illuminate\Support\Collection;

class AdminDashboardService {
    /**
    * Fetch all admins, authors, and readers,
    * tag each record with its role, then merge.
    *
    * @return Collection
    */

    public function getAllUsers(): Collection {
        $admins = Admin::select( 'id', 'name', 'email' )
        ->get()
        ->map( fn( $u ) => array_merge( $u->toArray(), [ 'role' => 'admin' ] ) );
        // dd( 'admins count = '.$admins->count() );
        $authors = Author::select( 'id', 'name', 'email' )
        ->get()
        ->map( fn( $u ) => array_merge( $u->toArray(), [ 'role' => 'author' ] ) );

        $readers = Reader::select( 'id', 'name', 'email' )
        ->get()
        ->map( fn( $u ) => array_merge( $u->toArray(), [ 'role' => 'reader' ] ) );

        return collect()
        ->concat( $admins )
        ->concat( $authors )
        ->concat( $readers )
        ->sortBy( 'role' )
        ->values();
    }
}