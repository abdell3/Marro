<?php

use App\Http\Controllers\BadgeController;
use App\Http\Controllers\CommunityController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\PollController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ReportTypeController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SavedPostController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\ThreadController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Community routes
Route::resource('communities', CommunityController::class);
Route::post('/communities/{community}/join', [CommunityController::class, 'join'])->name('communities.join');
Route::post('/communities/{community}/leave', [CommunityController::class, 'leave'])->name('communities.leave');

// Post routes
Route::resource('posts', PostController::class);
Route::post('/posts/{post}/upvote', [PostController::class, 'upvote'])->name('posts.upvote');
Route::post('/posts/{post}/downvote', [PostController::class, 'downvote'])->name('posts.downvote');

// Comment routes
Route::resource('comments', CommentController::class)->except(['index', 'show']);
Route::post('/comments/{comment}/upvote', [CommentController::class, 'upvote'])->name('comments.upvote');
Route::post('/comments/{comment}/downvote', [CommentController::class, 'downvote'])->name('comments.downvote');

// Thread routes
Route::resource('threads', ThreadController::class);

// Poll routes
Route::post('/polls', [PollController::class, 'store'])->name('polls.store');
Route::get('/polls/{poll}', [PollController::class, 'show'])->name('polls.show');
Route::post('/polls/{poll}/vote', [PollController::class, 'vote'])->name('polls.vote');
Route::get('/polls/{poll}/results', [PollController::class, 'results'])->name('polls.results');

// Saved posts routes
Route::get('/saved-posts', [SavedPostController::class, 'index'])->name('saved-posts.index');
Route::post('/saved-posts', [SavedPostController::class, 'store'])->name('saved-posts.store');
Route::delete('/saved-posts/{post}', [SavedPostController::class, 'destroy'])->name('saved-posts.destroy');

// Tag routes
Route::resource('tags', TagController::class);

// Report routes
Route::get('/reports/create', [ReportController::class, 'create'])->name('reports.create');
Route::post('/reports', [ReportController::class, 'store'])->name('reports.store');

// Badge routes
Route::get('/badges', [BadgeController::class, 'index'])->name('badges.index');
Route::get('/badges/{badge}', [BadgeController::class, 'show'])->name('badges.show');

// Admin routes
Route::middleware(['auth', 'can:admin'])->prefix('admin')->name('admin.')->group(function () {
    // Role management
    Route::resource('roles', RoleController::class);
    
    // Permission management
    Route::resource('permissions', PermissionController::class);
    
    // Report management
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/{report}', [ReportController::class, 'show'])->name('reports.show');
    Route::put('/reports/{report}', [ReportController::class, 'update'])->name('reports.update');
    Route::patch('/reports/{report}/status', [ReportController::class, 'updateStatus'])->name('reports.update-status');
    Route::delete('/reports/{report}', [ReportController::class, 'destroy'])->name('reports.destroy');
    
    
    Route::resource('report-types', ReportTypeController::class);
    
    
    Route::resource('badges', BadgeController::class)->except(['index', 'show']);
    Route::post('/badges/award', [BadgeController::class, 'awardBadge'])->name('badges.award');
    Route::post('/badges/revoke', [BadgeController::class, 'revokeBadge'])->name('badges.revoke');
});
