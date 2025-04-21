<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BadgeController;
use App\Http\Controllers\CommunityController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\HomeController;
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
use App\Models\Community;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'registerForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    Route::get('/login', [AuthController::class, 'loginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    // Route::get('/forgot-password', [AuthController::class, 'forgotPasswordForm'])->name('password.request');
    // Route::post('/forgot-password', [AuthController::class, 'sendResetLink'])->name('password.email');
    // Route::get('/reset-password/{token}', [AuthController::class, 'resetPasswordForm'])->name('password.reset');
    // Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');
});







Route::post('/logout', [AuthController::class, 'logout'])->name('logout');



Route::middleware(['auth'])->group(function () {

    Route::get('/home', [HomeController::class, 'index'])->name('auth.dashboard');

    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/profile/password', [ProfileController::class, 'editPassword'])->name('profile.password');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password.update');
    Route::get('/profile/delete', [ProfileController::class, 'confirmDelete'])->name('profile.delete');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });


Route::get('communities', [CommunityController::class, 'index'])->name('communities.index');
Route::resource('communities', CommunityController::class);
Route::post('/communities/{community}/join', [CommunityController::class, 'join'])->name('communities.join');
Route::post('/communities/{community}/leave', [CommunityController::class, 'leave'])->name('communities.leave');


Route::resource('posts', PostController::class);
Route::post('/posts/{post}/upvote', [PostController::class, 'upvote'])->name('posts.upvote');
Route::post('/posts/{post}/downvote', [PostController::class, 'downvote'])->name('posts.downvote');


Route::resource('comments', CommentController::class)->except(['index', 'show']);
Route::post('/comments/{comment}/upvote', [CommentController::class, 'upvote'])->name('comments.upvote');
Route::post('/comments/{comment}/downvote', [CommentController::class, 'downvote'])->name('comments.downvote');


Route::resource('threads', ThreadController::class);


Route::post('/polls', [PollController::class, 'store'])->name('polls.store');
Route::get('/polls/{poll}', [PollController::class, 'show'])->name('polls.show');
Route::post('/polls/{poll}/vote', [PollController::class, 'vote'])->name('polls.vote');
Route::get('/polls/{poll}/results', [PollController::class, 'results'])->name('polls.results');


Route::get('/saved-posts', [SavedPostController::class, 'index'])->name('saved-posts.index');
Route::post('/saved-posts', [SavedPostController::class, 'store'])->name('saved-posts.store');
Route::delete('/saved-posts/{post}', [SavedPostController::class, 'destroy'])->name('saved-posts.destroy');




Route::get('/reports/create', [ReportController::class, 'create'])->name('reports.create');
Route::post('/reports', [ReportController::class, 'store'])->name('reports.store');


Route::get('/badges/{badge}', [BadgeController::class, 'show'])->name('badges.show');


Route::middleware(['auth', 'checkRole:Admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/badges', [BadgeController::class, 'index'])->name('badges.index');

    Route::get('/communities/{community}', [CommunityController::class, 'show'])->name('communities.show');
    Route::delete('/communities/{community}', [CommunityController::class, 'destroy'])->name('communities.destroy');
    
    Route::get('communities', [CommunityController::class, 'index'])->name('communities.index');
    Route::resource('tags', TagController::class);

    Route::get('tag', [TagController::class, 'index'])->name('tags.index');
    Route::get('tags', [TagController::class, 'show'])->name('tags.show');
     



    Route::resource('roles', RoleController::class);
    Route::resource('permissions', PermissionController::class);

    Route::get('user', [UserController::class, 'index'])->name('users.index');
    Route::get('users', [UserController::class, 'show'])->name('users.show');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
    
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




// use App\Http\Controllers\Admin\CommentController;
// use App\Http\Controllers\Admin\DashboardController;
// // use App\Http\Controllers\Admin\PostController;
// use App\Http\Controllers\Admin\UserController;
// use App\Http\Controllers\AuthController;
// use App\Http\Controllers\CommunityController;
// use App\Http\Controllers\HomeController;
// use App\Http\Controllers\PostController;
// use App\Http\Controllers\ReportController;
// use App\Http\Controllers\TagController;
// use App\Http\Controllers\ThreadController;
// use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });


// Route::post('/reports', [ReportController::class, 'store'])->name('reports.store');

// Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');




//     Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

//     Route::resource('tags', TagController::class);
    
//     Route::resource('users', UserController::class);    




//     Route::get('/', [HomeController::class, 'index'])->name('home');



// Route::middleware('auth')->group(function () {
//     Route::get('/dashboard', function () {
//         return view('auth.dashboard');
//     })->name('auth.dashboard');

//     Route::resource('communities', CommunityController::class);
//     Route::resource('threads', ThreadController::class);
    
    
//     Route::middleware(['auth', 'permission:view-posts'])->group(function () {
//         Route::get('/posts', [PostController::class, 'index'])->name('posts.index');
//         Route::get('/posts/create', [PostController::class, 'create'])->middleware('permission:create-posts')->name('posts.create');
//         Route::post('/posts', [PostController::class, 'store'])->middleware('permission:create-posts')->name('posts.store');
//         Route::get('/posts/{post}', [PostController::class, 'show'])->name('posts.show');
//         Route::get('/posts/{post}/edit', [PostController::class, 'edit'])->middleware('permission:edit-posts')->name('posts.edit');
//         Route::put('/posts/{post}', [PostController::class, 'update'])->middleware('permission:edit-posts')->name('posts.update');
//         Route::delete('/posts/{post}', [PostController::class, 'destroy'])->middleware('permission:delete-posts')->name('posts.destroy');
//     });

//     Route::post('/comments', [CommentController::class, 'store'])->name('comments.store');
//     Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');


//     });


// Route::middleware(['auth'])->group(function () {
//     Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
//     Route::get('/communities', [UserController::class, 'communities'])->name('users.communities');
//     Route::get('/reported', [ReportController::class, 'reported'])->name('reported');
// });
// ;


