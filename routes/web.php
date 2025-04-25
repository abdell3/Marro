<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\CommunityController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ModerationController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Home routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/home', [HomeController::class, 'index']);
Route::get('/search', [HomeController::class, 'search'])->name('search');

// Auth routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    Route::get('/forgot-password', [AuthController::class, 'showForgotPasswordForm'])->name('password.request');
    Route::post('/forgot-password', [AuthController::class, 'sendPasswordResetLink'])->name('password.email');
    Route::get('/reset-password/{token}', [AuthController::class, 'showResetPasswordForm'])->name('password.reset');
    Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    // User routes
    Route::get('/dashboard', [UserController::class, 'dashboard'])->name('dashboard');
    Route::get('/profile', [UserController::class, 'profile'])->name('profile');
    Route::get('/profile/edit', [UserController::class, 'editProfile'])->name('profile.edit');
    Route::put('/profile', [UserController::class, 'updateProfile']);
    Route::get('/settings', [UserController::class, 'settings'])->name('settings');
    Route::put('/settings/notifications', [UserController::class, 'updateNotificationSettings'])->name('settings.update-notifications');
    Route::put('/settings/privacy', [UserController::class, 'updatePrivacySettings'])->name('settings.update-privacy');
    Route::put('/profile/avatar', [UserController::class, 'updateAvatar'])->name('profile.update-avatar');
    Route::delete('/account', [UserController::class, 'deleteAccount'])->name('account.delete');
    Route::get('/change-password', [UserController::class, 'showChangePasswordForm'])->name('password.change');
    Route::put('/change-password', [UserController::class, 'changePassword']);
    Route::get('/saved-posts', [UserController::class, 'savedPosts'])->name('saved-posts');
    Route::get('/communities', [UserController::class, 'communities'])->name('user.communities');
    
    // Email verification
    Route::get('/verify-email/{token}', [AuthController::class, 'verifyEmail'])->name('verification.verify');
    
    // Post routes
    Route::resource('posts', PostController::class);
    Route::post('/posts/{post}/vote', [PostController::class, 'vote'])->name('posts.vote');
    Route::post('/posts/{post}/save', [PostController::class, 'save'])->name('posts.save');
    Route::post('/posts/{post}/report', [PostController::class, 'report'])->name('posts.report');
    
    // Comment routes
    Route::resource('comments', CommentController::class)->except(['index', 'create', 'show']);
    Route::post('/comments/{comment}/report', [CommentController::class, 'report'])->name('comments.report');
    Route::get('/comments/{comment}/reply', [CommentController::class, 'reply'])->name('comments.reply');
    Route::post('/comments/{comment}/reply', [CommentController::class, 'storeReply'])->name('comments.storeReply');
    
    // Community routes
    Route::resource('communities', CommunityController::class);
    Route::post('/communities/{community}/subscribe', [CommunityController::class, 'toggleSubscription'])->name('communities.subscribe');
    
    // Moderation routes (moderator or admin only)
    Route::middleware('role:moderator|admin')->group(function () {
        Route::get('/moderation', [ModerationController::class, 'index'])->name('moderation');
        Route::get('/moderation/reports/{report}', [ModerationController::class, 'show'])->name('moderation.reports.show');
        Route::post('/moderation/reports/{report}/handle', [ModerationController::class, 'handleReport'])->name('moderation.reports.handle');
        Route::get('/moderation/reported-posts', [ModerationController::class, 'reportedPosts'])->name('moderation.reported-posts');
        Route::get('/moderation/reported-comments', [ModerationController::class, 'reportedComments'])->name('moderation.reported-comments');
    });
    
    // Admin routes (admin only)
    Route::middleware('role:admin')->group(function () {
        Route::get('/admin', [AdminController::class, 'index'])->name('admin.dashboard');
        Route::get('/admin/users', [AdminController::class, 'users'])->name('admin.users');
        Route::put('/admin/users/{user}/role', [AdminController::class, 'updateUserRole'])->name('admin.users.update-role');
        Route::delete('/admin/users/{user}', [AdminController::class, 'deleteUser'])->name('admin.users.delete');
        Route::post('/admin/users/{user}/ban', [AdminController::class, 'banUser'])->name('admin.users.ban');
        Route::get('/admin/roles', [AdminController::class, 'roles'])->name('admin.roles');
        Route::put('/admin/roles/{role}/permissions', [AdminController::class, 'updateRolePermissions'])->name('admin.roles.update-permissions');
    });
});
