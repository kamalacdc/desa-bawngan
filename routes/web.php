<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\ActivityLogController;
use App\Http\Controllers\Admin\AccountController;
use App\Http\Controllers\Admin\ApprovalController;
use App\Http\Controllers\Admin\BudgetDataController;
use App\Http\Controllers\Admin\ContentController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\GalleryController;
use App\Http\Controllers\Admin\LeaderController;
use App\Http\Controllers\Admin\NewsController;
use App\Http\Controllers\Admin\PopulationDataController;
use App\Http\Controllers\Admin\UserManagementController;
use Illuminate\Support\Facades\Route;

// ─── Public Frontend ─────────────────────────────────────
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/demografi', [HomeController::class, 'demografi'])->name('demografi');
Route::get('/apbdes', [HomeController::class, 'apbdes'])->name('apbdes');
Route::get('/berita', [HomeController::class, 'news'])->name('berita');
Route::get('/berita/{slug}', [HomeController::class, 'newsDetail'])->name('berita.detail');

// ─── Authentication ──────────────────────────────────────
Route::get('/login', [AuthController::class, 'showLogin'])->name('login')->middleware('guest');
Route::post('/login', [AuthController::class, 'login'])->middleware('guest');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Password Reset Routes
Route::get('/forgot-password', [AuthController::class, 'showForgotPassword'])->name('password.request')->middleware('guest');
Route::post('/forgot-password', [AuthController::class, 'sendResetLinkEmail'])->name('password.email')->middleware('guest');
Route::get('/reset-password/{token}', [AuthController::class, 'showResetPassword'])->name('password.reset')->middleware('guest');
Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update')->middleware('guest');

// ─── Admin Dashboard ─────────────────────────────────────
Route::prefix('admin')
    ->middleware(['auth', 'role:super_admin,admin'])
    ->group(function () {

        // Dashboard
        Route::get('/', [DashboardController::class, 'index'])->name('admin.dashboard');

        // News CRUD (both Super Admin & Admin Staff)
        Route::resource('news', NewsController::class)->names('admin.news');
        Route::post('news/{news}/submit', [NewsController::class, 'submit'])->name('admin.news.submit');

        // Account Profile & Security (all admins & super admins)
        Route::get('account/profile', [AccountController::class, 'profile'])->name('admin.account.profile');
        Route::put('account/profile', [AccountController::class, 'updateProfile'])->name('admin.account.update-profile');
        Route::delete('account/avatar', [AccountController::class, 'removeAvatar'])->name('admin.account.remove-avatar');
        Route::get('account/change-password', [AccountController::class, 'showChangePassword'])->name('admin.account.change-password');
        Route::put('account/change-password', [AccountController::class, 'updatePassword'])->name('admin.account.update-password');

        // ─── Super Admin Only ────────────────────────────
        Route::middleware('role:super_admin')->group(function () {

            // Activity Logs System (Super Admin Only)
            Route::get('activity-logs', [ActivityLogController::class, 'index'])->name('admin.activity-logs');
            Route::delete('activity-logs/clear', [ActivityLogController::class, 'clear'])->name('admin.activity-logs.clear');

            // Approval System
            Route::get('approvals', [ApprovalController::class, 'index'])->name('admin.approvals');
            Route::post('approvals/{news}/approve', [ApprovalController::class, 'approve'])->name('admin.approvals.approve');
            Route::post('approvals/{news}/reject', [ApprovalController::class, 'reject'])->name('admin.approvals.reject');

            // Content Management
            Route::get('content/slides', [ContentController::class, 'slides'])->name('admin.content.slides');
            Route::put('content/slides', [ContentController::class, 'updateSlides'])->name('admin.content.slides.update');
            Route::get('content/visi-misi', [ContentController::class, 'visiMisi'])->name('admin.content.visi-misi');
            Route::put('content/visi-misi', [ContentController::class, 'updateVisiMisi'])->name('admin.content.visi-misi.update');
            Route::get('content/sejarah', [ContentController::class, 'sejarah'])->name('admin.content.sejarah');
            Route::put('content/sejarah', [ContentController::class, 'updateSejarah'])->name('admin.content.sejarah.update');
            Route::get('content/profile', [ContentController::class, 'profile'])->name('admin.content.profile');
            Route::put('content/profile', [ContentController::class, 'updateProfile'])->name('admin.content.profile.update');
            Route::get('content/sambutan', [ContentController::class, 'sambutan'])->name('admin.content.sambutan');
            Route::put('content/sambutan', [ContentController::class, 'updateSambutan'])->name('admin.content.sambutan.update');
            Route::resource('galleries', GalleryController::class)->names('admin.galleries');

            // Data Management
            Route::resource('leaders', LeaderController::class)->names('admin.leaders');
            Route::resource('population', PopulationDataController::class)->names('admin.population');
            Route::post('population/sync', [PopulationDataController::class, 'syncFromSpreadsheet'])->middleware('throttle:10,1')->name('admin.population.sync');
            Route::resource('budget', BudgetDataController::class)->names('admin.budget');
            Route::post('budget/sync', [BudgetDataController::class, 'syncFromSpreadsheet'])->middleware('throttle:10,1')->name('admin.budget.sync');

            // User Management
            Route::resource('users', UserManagementController::class)->names('admin.users')->except(['show']);
        });

        // Chart API endpoints (Rate limited to 60 requests per minute)
        Route::middleware('throttle:60,1')->group(function () {
            Route::get('api/population-chart/{year}', [PopulationDataController::class, 'chartData'])->name('admin.api.population-chart');
            Route::get('api/budget-chart/{year}', [BudgetDataController::class, 'chartData'])->name('admin.api.budget-chart');
        });
    });