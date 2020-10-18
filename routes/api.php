<?php

use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\Design\CommentController;
use App\Http\Controllers\Design\DesignController;
use App\Http\Controllers\Design\UploadController;
use App\Http\Controllers\MeController;
use App\Http\Controllers\Teams\TeamsController;
use App\Http\Controllers\Teams\InvitationsController;
use App\Http\Controllers\User\SettingController;
use App\Http\Controllers\User\UserController;
use Illuminate\Support\Facades\Route;

//Public routes
Route::get('me', MeController::class);

// designs
Route::get('designs', [DesignController::class, 'index']);
Route::get('designs/{id}', [DesignController::class, 'findDesign']);

//users
Route::get('users', [UserController::class, 'index']);

//Team
Route::get('team/slug/{slug}', [TeamsController::class, 'findBySlug']);

// Route group for authenticated users only
Route::group(['middleware' => ['auth:api']], function () {
    Route::post('logout', [LoginController::class, 'logout']);
    Route::put('settings/profile', [SettingController::class, 'updateProfile']);
    Route::put('settings/password', [SettingController::class, 'updatePassword']);

    //upload Design
    Route::post('designs', [UploadController::class, 'upload']);
    Route::put('designs/{id}', [DesignController::class, 'update']);
    Route::delete('designs/{id}', [DesignController::class, 'destroy']);
    
    //Like and Unlikes
    Route::post('designs/{id}/like', [DesignController::class, 'like']);
    Route::post('designs/{id}/liked', [DesignController::class, 'checkIfUserHasLiked']);

    //comments
    Route::post('designs/{id}/comments', [CommentController::class, 'store']);
    Route::put('comments/{id}', [CommentController::class, 'update']);
    Route::delete('comments/{id}', [CommentController::class, 'destroy']);

    // Teams
    Route::post('teams', [TeamsController::class, 'store']);
    Route::get('teams/{id}', [TeamsController::class, 'findById']);
    Route::get('teams', [TeamsController::class, 'index']);
    Route::get('users/teams', [TeamsController::class, 'fetchUserTeams']);
    Route::put('teams/{id}', [TeamsController::class, 'update']);
    Route::delete('teams/{id}', [TeamsController::class, 'destroy']);
    Route::delete('teams/{team_id}/users/{user_id}', [TeamsController::class, 'removeFromTeam']);

    // Invitations
    Route::post('invitations/{teamId}', [InvitationsController::class, 'invite']);
    Route::post('invitations/{id}/resend', [InvitationsController::class, 'resend']);
    Route::post('invitations/{id}/respond', [InvitationsController::class, 'respond']);
    Route::delete('invitations/{id}', [InvitationsController::class, 'destroy']);
});

//Routes for guests only
Route::group(['middleware' => ['guest:api']], function () {
    Route::post('register', [RegisterController::class, 'register']);
    Route::post('verification/verify/{user}', [VerificationController::class, 'verify'])->name('verification.verify');
    Route::post('verification/resend', [VerificationController::class, 'resend']);
    Route::post('login', [LoginController::class, 'login']);
    Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail']);
    Route::post('password/reset', [ResetPasswordController::class, 'reset']);
});
