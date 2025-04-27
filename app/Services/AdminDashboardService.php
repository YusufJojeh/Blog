<?php

namespace App\Services;

use App\Models\Admin;
use App\Models\Author;
use App\Models\Reader;
use App\Models\Post;
use App\Models\Comment;
use Carbon\Carbon;
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

    /**
    * Get total counts for each user role and overall.
    *
    * @return array
    */

    public function getUserStats(): array {
        $admins  = Admin::count();
        $authors = Author::count();
        $readers = Reader::count();

        return [
            'admins'  => $admins,
            'authors' => $authors,
            'readers' => $readers,
            'total'   => $admins + $authors + $readers,
        ];
    }

    /**
    * Get counts of posts by status.
    *
    * @return array
    */

    public function getPostStats(): array {
        return [
            'published' => Post::where( 'status', 'published' )->count(),
            'drafts'    => Post::where( 'status', 'draft' )->count(),
            'scheduled' => Post::where( 'published_at', '>', Carbon::now() )->count(),
        ];
    }

    /**
    * Get counts of comments by approval state.
    *
    * @return array
    */

    public function getCommentStats(): array {
        return [
            'pending'  => Comment::where( 'approved', false )->count(),
            'approved' => Comment::where( 'approved', true )->count(),
            'flagged'  => Comment::where( 'flagged', true )->count(),
        ];
    }

    /**
    * Count new registrations in the last X days.
    *
    * @param  int  $days
    * @return int
    */

    public function getNewRegistrations( int $days = 7 ): int {
        $since = Carbon::now()->subDays( $days );

        return Admin::where( 'created_at', '>=', $since )->count()
        + Author::where( 'created_at', '>=', $since )->count()
        + Reader::where( 'created_at', '>=', $since )->count();
    }

    /**
    * Fetch the most recent posts.
    *
    * @param  int  $limit
    * @return Collection
    */

    public function getRecentPosts( int $limit = 5 ): Collection {
        return Post::with( 'author' )
        ->latest()
        ->limit( $limit )
        ->get();
    }

    /**
    * Build an array of dates => post-count for the past X days.
    *
    * @param  int  $days
    * @return array
    */

    public function getPostsPerDay( int $days = 30 ): array {
        $stats = [];
        for ( $i = $days - 1; $i >= 0; $i-- ) {
            $date = Carbon::now()->subDays( $i )->format( 'Y-m-d' );
            $stats[ $date ] = Post::whereDate( 'published_at', $date )->count();
        }
        return $stats;
    }

    /**
    * Build an array of 'Month Year' => sign-up count for the past X months.
    *
    * @param  int  $months
    * @return array
    */

    public function getUserSignUps( int $months = 6 ): array {
        $stats = [];
        for ( $i = $months - 1; $i >= 0; $i-- ) {
            $date  = Carbon::now()->subMonths( $i );
            $label = $date->format( 'M Y' );
            $count = Admin::whereYear( 'created_at', $date->year )
            ->whereMonth( 'created_at', $date->month )->count()
            + Author::whereYear( 'created_at', $date->year )
            ->whereMonth( 'created_at', $date->month )->count()
            + Reader::whereYear( 'created_at', $date->year )
            ->whereMonth( 'created_at', $date->month )->count();
            $stats[ $label ] = $count;
        }
        return $stats;
    }
}
