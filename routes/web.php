<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SubmissionController;
use App\Http\Controllers\EntriesController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\User\UserDashboardController;
use App\Http\Controllers\Manager\ManagerHomeController;
use App\Http\Controllers\Manager\ManagerDashboardController;

use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\DesignationController;
use App\Http\Controllers\DeletionRequestController;

use App\Http\Controllers\SignatureController;
use App\Http\Controllers\Auth\VerificationController;

use App\Http\Controllers\NotificationController;
use App\Http\Controllers\SubmissionTypeController;


Route::get('/', fn() => redirect()->route('login'));




Route::get('/verify-email/{id}/{hash}',
    [VerificationController::class, 'verify'])
    ->middleware(['auth', 'signed', 'throttle:6,1'])
    ->name('verification.verify');

Route::middleware(['auth', 'verified'])->group(function () {

    

    // ── Smart redirect based on role ──────────────────────────────────────
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // ── Profile (all roles) ───────────────────────────────────────────────
    Route::get('/profile',            [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile',          [ProfileController::class, 'update'])->name('profile.update');
    Route::patch('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');
    Route::delete('/profile',         [ProfileController::class, 'destroy'])->name('profile.destroy');

    // ── Entries datatable (all roles) ─────────────────────────────────────
    Route::get('/entries', [EntriesController::class, 'index'])->name('entries.table');
    Route::post('/signature',   [SignatureController::class, 'update'])->name('signature.update');
    Route::delete('/signature', [SignatureController::class, 'destroy'])->name('signature.destroy');

    // ── User routes ───────────────────────────────────────────────────────
    Route::middleware(['role:user'])->group(function () {
        Route::get('/user/dashboard', [UserDashboardController::class, 'index'])->name('user.dashboard');

        Route::get('/submissions/select-type', [SubmissionTypeController::class, 'index'])
        ->name('submissions.select-type');

        Route::get('/submissions/create/analytical-report', [SubmissionTypeController::class, 'createAnalyticalReport'])
            ->name('submissions.create.analytical-report');

        Route::get('/submissions/create/analytical-report/type', [SubmissionTypeController::class, 'analyticalReportType'])
            ->name('submissions.analytical-report.type');
    });

    // ── Submission routes (all authenticated users) ───────────────────────
    Route::get('/submissions',                   [SubmissionController::class, 'index'])->name('submissions.index');
    Route::get('/submissions/create',            [SubmissionController::class, 'create'])->name('submissions.create');
    Route::post('/submissions',                  [SubmissionController::class, 'store'])->name('submissions.store');
    Route::get('/submissions/{submission}/edit', [SubmissionController::class, 'edit'])->name('submissions.edit');
    Route::patch('/submissions/{submission}',    [SubmissionController::class, 'update'])->name('submissions.update');
    Route::delete('/submissions/{submission}',   [SubmissionController::class, 'destroy'])->name('submissions.destroy');

    

    // ── Admin only routes ─────────────────────────────────────────────────
    Route::middleware(['role:admin'])->group(function () {
        Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
        
        Route::resource('roles', RoleController::class)->except(['show']);
        //Department management and designation management
        Route::resource('departments', DepartmentController::class)->except(['show']);
        Route::get('/departments/{department}/functions', [DepartmentController::class, 'functions'])
            ->name('departments.functions');

        Route::get('/designations',               [DesignationController::class, 'index'])->name('designations.index');
        Route::post('/designations',              [DesignationController::class, 'store'])->name('designations.store');
        Route::patch('/designations/{designation}', [DesignationController::class, 'update'])->name('designations.update');
        Route::delete('/designations/{designation}', [DesignationController::class, 'destroy'])->name('designations.destroy');


    });

    // ── Admin & Manager routes ────────────────────────────────────────────
    Route::middleware(['role:admin,manager'])->group(function () {

        // Manager home (greeting page)
        Route::get('/manager/home', [ManagerHomeController::class, 'index'])->name('manager.home');

        // Manager review page
        Route::get('/manager/dashboard', [ManagerDashboardController::class, 'index'])->name('manager.dashboard');

        // Submission actions
        Route::post('/submissions/{submission}/approve',      [ManagerDashboardController::class, 'approve'])->name('submissions.approve');
        Route::post('/submissions/{submission}/reject',       [ManagerDashboardController::class, 'reject'])->name('submissions.reject');
        Route::post('/submissions/{submission}/request-edit', [ManagerDashboardController::class, 'requestEdit'])->name('submissions.request-edit');

        // User management
        Route::resource('users', UserController::class)->except(['show']);


        // Manager can submit deletion request
        Route::post('/deletion-requests', [DeletionRequestController::class, 'store'])
            ->name('deletion-requests.store')
            ->middleware('role:manager');

        // Admin manages deletion requests
        Route::middleware(['role:admin'])->group(function () {
            Route::get('/deletion-requests', [DeletionRequestController::class, 'index'])
                ->name('deletion-requests.index');
            Route::post('/deletion-requests/{deletionRequest}/approve', [DeletionRequestController::class, 'approve'])
                ->name('deletion-requests.approve');
            Route::post('/deletion-requests/{deletionRequest}/reject', [DeletionRequestController::class, 'reject'])
                ->name('deletion-requests.reject');
        });

        Route::post('/users/{user}/resend-verification',
            [UserController::class, 'resendVerification'])
            ->name('users.resend-verification')
            ->middleware('role:admin,manager');
    });


});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/notifications',            [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/{id}/read', [NotificationController::class, 'markRead'])->name('notifications.read');
    Route::post('/notifications/read-all',  [NotificationController::class, 'markAllRead'])->name('notifications.read-all');
});



require __DIR__ . '/auth.php';