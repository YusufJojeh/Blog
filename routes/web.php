<?php

use App\Http\Controllers\AdminDashboard;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\ReaderController;
use App\Http\Controllers\UserManagemantController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ModerationController;
use App\Http\Controllers\SiteSettingsController;



Route::get('/', fn() => view('welcome'));

Route::get('posts',        [PostController::class, 'index'])
     ->name('posts.index');
Route::get('posts/{post}', [PostController::class, 'show'])
     ->name('posts.show');




Route::get('admin/login',  [LoginController::class, 'showLoginForm'])
     ->name('admin.login');
Route::post('admin/login', [LoginController::class, 'login'])
     ->name('admin.login.submit');


Route::get('author/login',  [LoginController::class, 'showLoginForm'])
     ->name('author.login');
Route::post('author/login', [LoginController::class, 'login'])
     ->name('author.login.submit');

Route::get('reader/login',  [LoginController::class, 'showLoginForm'])
     ->name('reader.login');
Route::post('reader/login', [LoginController::class, 'login'])
     ->name('reader.login.submit');


Route::get('login',  [LoginController::class, 'showLoginForm'])
     ->name('login');
Route::post('login', [LoginController::class, 'login'])
     ->name('login.submit');

Route::post('logout', [LoginController::class, 'logout'])
     ->name('logout');



Route::middleware('auth.guard:admin')
     ->prefix('admin')
     ->as('admin.')
     ->group(function () {
         // Dashboard
         Route::get('dashboard', [AdminDashboard::class, 'dashboard'])
              ->name('dashboard');

         // User Management
         Route::get('users',          [UserManagemantController::class, 'index'])
              ->name('users.index');
         Route::get('users/create',   [UserManagemantController::class, 'create'])
              ->name('users.create');
         Route::post('users',         [UserManagemantController::class, 'store'])
              ->name('users.store');
         Route::get('users/{role}/{id}',           [UserManagemantController::class, 'show'])
              ->whereIn('role', ['admin', 'author', 'reader'])
              ->name('users.show');
         Route::get('users/{role}/{id}/edit',      [UserManagemantController::class, 'edit'])
              ->whereIn('role', ['admin', 'author', 'reader'])
              ->name('users.edit');
         Route::put('users/{role}/{id}',           [UserManagemantController::class, 'update'])
              ->whereIn('role', ['admin', 'author', 'reader'])
              ->name('users.update');
         Route::delete('users/{role}/{id}',        [UserManagemantController::class, 'destroy'])
              ->whereIn('role', ['admin', 'author', 'reader'])
              ->name('users.destroy');

      Route::get   ('categories',              [CategoryController::class, 'index'])  ->name('categories.index');
         Route::get   ('categories/create',       [CategoryController::class, 'create']) ->name('categories.create');
         Route::post  ('categories',              [CategoryController::class, 'store'])  ->name('categories.store');
         Route::get   ('categories/{category}/edit',[CategoryController::class,'edit'])   ->name('categories.edit');
         Route::put   ('categories/{category}',   [CategoryController::class, 'update']) ->name('categories.update');
         Route::delete('categories/{category}',   [CategoryController::class, 'destroy'])->name('categories.destroy');


            Route::get   ('moderation/reported-posts',           [ModerationController::class, 'reportedPosts'])
                                                                        ->name('moderation.reported-posts');
            Route::post  ('moderation/reported-posts/{post}/unflag', [ModerationController::class, 'unflagPost'])
                                                                        ->name('moderation.reported-posts.unflag');
            Route::delete('moderation/reported-posts/{post}',      [ModerationController::class, 'deletePost'])
                                                                        ->name('moderation.reported-posts.delete');

            Route::get   ('moderation/reported-comments',        [ModerationController::class, 'reportedComments'])
                                                                        ->name('moderation.reported-comments');
            Route::post  ('moderation/reported-comments/{comment}/unflag', [ModerationController::class, 'unflagComment'])
                                                                    ->name('moderation.reported-comments.unflag');
            Route::delete('moderation/reported-comments/{comment}',      [ModerationController::class, 'deleteComment'])
                                                                        ->name('moderation.reported-comments.delete');
                                                                        Route::get('settings', [SiteSettingsController::class, 'index'])
                ->name('settings.index');

        Route::post('settings', [SiteSettingsController::class, 'update'])
                ->name('settings.update');
        });



Route::middleware('auth.guard:author')
        ->prefix('author')
        ->as('author.')
        ->group(function () {
         // Dashboard
            Route::get('dashboard', [AuthorController::class, 'index'])
                ->name('dashboard');

         // Can only create, update own posts
            Route::resource('posts', PostController::class)
                ->only(['create', 'store', 'edit', 'update'])
                ->names('posts');
        });



Route::middleware('auth.guard:reader')
        ->prefix('reader')
        ->as('reader.')
        ->group(function () {
         // Dashboard
            Route::get('dashboard', [ReaderController::class, 'index'])
                ->name('dashboard');
        });
