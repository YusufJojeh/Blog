<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Author\PostController;
use App\Http\Controllers\Author\CommentController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ProfileController ;
use App\Http\Controllers\Admin\AdminDashboard;
use App\Http\Controllers\Author\AuthorController;
use App\Http\Controllers\Reader\ReaderController;
use App\Http\Controllers\Admin\UserManagemantController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ModerationController;
use App\Http\Controllers\Admin\SiteSettingsController;

Route::get('/', fn() => view('welcome'));


Route::get ('admin/login',   [LoginController::class,'showLoginForm'])->name('admin.login');
Route::post('admin/login',   [LoginController::class,'login'])          ->name('admin.login.submit');
Route::get ('author/login',  [LoginController::class,'showLoginForm'])->name('author.login');
Route::post('author/login',  [LoginController::class,'login'])          ->name('author.login.submit');
Route::get ('reader/login',  [LoginController::class,'showLoginForm'])->name('reader.login');
Route::post('reader/login',  [LoginController::class,'login'])          ->name('reader.login.submit');
Route::get ('login',         [LoginController::class,'showLoginForm'])->name('login');
Route::post('login',         [LoginController::class,'login'])          ->name('login.submit');
Route::post('logout',        [LoginController::class,'logout'])         ->name('logout');


// ──────────────────────────────────────────────────────────────────────────────
// Admin
// ──────────────────────────────────────────────────────────────────────────────
Route::middleware('auth.guard:admin')
     ->prefix('admin')
     ->as('admin.')
     ->group(function () {
         Route::get('dashboard', [AdminDashboard::class,   'dashboard'])     ->name('dashboard');

         // Profile
         Route::get ('profile', [ProfileController::class, 'show'])          ->name('profile.show');
         Route::post('profile', [ProfileController::class, 'update'])        ->name('profile.update');

         // User Management
         Route::resource('users', UserManagemantController::class)
              ->except(['show'])
              ->names('users');

         // Category Management
         Route::resource('categories', CategoryController::class)
              ->except(['show'])
              ->names('categories');

         // Content Moderation
         Route::get   ('moderation/reported-posts',                [ModerationController::class,'reportedPosts'])
                                                                      ->name('moderation.reported-posts');
         Route::post  ('moderation/reported-posts/{post}/unflag',  [ModerationController::class,'unflagPost'])
                                                                      ->name('moderation.reported-posts.unflag');
         Route::delete('moderation/reported-posts/{post}',         [ModerationController::class,'deletePost'])
                                                                      ->name('moderation.reported-posts.delete');

         Route::get   ('moderation/reported-comments',                [ModerationController::class,'reportedComments'])
                                                                      ->name('moderation.reported-comments');
         Route::post  ('moderation/reported-comments/{comment}/unflag',[ModerationController::class,'unflagComment'])
                                                                      ->name('moderation.reported-comments.unflag');
         Route::delete('moderation/reported-comments/{comment}',      [ModerationController::class,'deleteComment'])
                                                                      ->name('moderation.reported-comments.delete');

         // Site Settings
         Route::get ('settings', [SiteSettingsController::class,'index'])  ->name('settings.index');
         Route::post('settings', [SiteSettingsController::class,'update']) ->name('settings.update');
     });


// ──────────────────────────────────────────────────────────────────────────────
// Author
// ──────────────────────────────────────────────────────────────────────────────
Route::middleware('auth.guard:author')
     ->prefix('author')
     ->as('author.')
     ->group(function () {
         // Dashboard & Profile
         Route::get('dashboard', [AuthorController::class,'index'])  ->name('dashboard');
         Route::get ('profile',  [ProfileController::class,'show'])   ->name('profile.show');
         Route::post('profile',  [ProfileController::class,'update']) ->name('profile.update');

         // My Articles
         Route::get('posts',            [PostController::class,'index'])     ->name('posts.index');
         Route::get('posts/drafts',     [PostController::class,'drafts'])    ->name('posts.drafts');
         Route::get('posts/scheduled',  [PostController::class,'scheduled'])->name('posts.scheduled');

         // Standard CRUD for posts (create, store, edit, update, destroy)
        Route::resource('posts', PostController::class)
              ->except(['show'])
              ->names('posts');
 Route::get('comments', [CommentController::class,'index'])->name('comments.index');
         Route::post('comments/{comment}/approve', [CommentController::class,'approve'])->name('comments.approve');
         Route::get('comments/spam', [CommentController::class,'spam'])->name('comments.spam');
     });


// ──────────────────────────────────────────────────────────────────────────────
// Reader
// ──────────────────────────────────────────────────────────────────────────────
Route::middleware('auth.guard:reader')
     ->prefix('reader')
     ->as('reader.')
     ->group(function () {
         Route::get('dashboard', [ReaderController::class,'index']) ->name('dashboard');
         Route::get ('profile',  [ProfileController::class,'show'])   ->name('profile.show');
         Route::post('profile',  [ProfileController::class,'update']) ->name('profile.update');

           Route::get('bookmarks', [BookmarkController::class, 'index'])
         ->name('bookmarks.index');
    Route::post('bookmarks/{article}', [BookmarkController::class, 'store'])
         ->name('bookmarks.store');
    Route::delete('bookmarks/{article}', [BookmarkController::class, 'destroy'])
         ->name('bookmarks.destroy');

    // My Comments
    Route::get('comments', [CommentController::class, 'index.'])
         ->name('comments.index');

    // Search Articles
    Route::get('search', [SearchController::class, 'articles'])
         ->name('search');

    // Preferences
    Route::get('preferences', [PreferenceController::class, 'edit'])
         ->name('preferences.edit');
    Route::post('preferences', [PreferenceController::class, 'update'])
         ->name('preferences.update');
     });
