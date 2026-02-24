<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\ProposalController;
use App\Http\Controllers\StatController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\AiController;

// ─── AUTH (public) ───────────────────────────────────────
Route::prefix('auth')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login',    [AuthController::class, 'login']);
});

// ─── ROUTES PROTÉGÉES (auth:sanctum) ─────────────────────
Route::middleware('auth:sanctum')->group(function () {

    // Auth
    Route::post('/auth/logout', [AuthController::class, 'logout']);
    Route::get('/auth/me',      [AuthController::class, 'me']);

    // Users
    Route::get('/users/{id}',    [UserController::class, 'show']);
    Route::put('/users/{id}',    [UserController::class, 'update']);
    Route::post('/users/{id}/follow',   [UserController::class, 'follow']);
    Route::post('/users/{id}/unfollow', [UserController::class, 'unfollow']);

    // Posts
    Route::get('/posts',          [PostController::class, 'index']);
    Route::post('/posts',         [PostController::class, 'store']);
    Route::get('/posts/{id}',     [PostController::class, 'show']);
    Route::put('/posts/{id}',     [PostController::class, 'update']);
    Route::delete('/posts/{id}',  [PostController::class, 'destroy']);

    // Comments
    Route::get('/posts/{id}/comments',  [CommentController::class, 'index']);
    Route::post('/posts/{id}/comments', [CommentController::class, 'store']);
    Route::delete('/comments/{id}',     [CommentController::class, 'destroy']);

    // Likes
    Route::post('/posts/{id}/like',    [LikeController::class, 'togglePost']);
    Route::post('/comments/{id}/like', [LikeController::class, 'toggleComment']);

    // Projects
    Route::get('/projects',         [ProjectController::class, 'index']);
    Route::post('/projects',        [ProjectController::class, 'store']);
    Route::get('/projects/{id}',    [ProjectController::class, 'show']);
    Route::put('/projects/{id}',    [ProjectController::class, 'update']);
    Route::delete('/projects/{id}', [ProjectController::class, 'destroy']);
    Route::post('/projects/{id}/join',  [ProjectController::class, 'join']);
    Route::post('/projects/{id}/leave', [ProjectController::class, 'leave']);

    // Jobs
    Route::get('/jobs',         [JobController::class, 'index']);
    Route::post('/jobs',        [JobController::class, 'store']);
    Route::get('/jobs/{id}',    [JobController::class, 'show']);
    Route::put('/jobs/{id}',    [JobController::class, 'update']);
    Route::delete('/jobs/{id}', [JobController::class, 'destroy']);

    // Proposals
    Route::post('/jobs/{id}/proposals',      [ProposalController::class, 'store']);
    Route::get('/jobs/{id}/proposals',       [ProposalController::class, 'index']);
    Route::put('/proposals/{id}/accept',     [ProposalController::class, 'accept']);
    Route::put('/proposals/{id}/reject',     [ProposalController::class, 'reject']);

    // Notifications
    Route::get('/notifications',          [NotificationController::class, 'index']);
    Route::put('/notifications/{id}/read', [NotificationController::class, 'markAsRead']);
    Route::put('/notifications/read-all', [NotificationController::class, 'markAllAsRead']);

    // Stats
    Route::get('/stats/skills',     [StatController::class, 'skills']);
    Route::get('/stats/frameworks', [StatController::class, 'frameworks']);
    Route::get('/stats/overview',   [StatController::class, 'overview']);

    // Search
    Route::get('/search', [SearchController::class, 'global']);

    // AI Assistant
    Route::post('/ai/chat',        [AiController::class, 'chat']);
    Route::get('/ai/suggestions',  [AiController::class, 'suggestions']);
});