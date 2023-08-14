<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RegisterController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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

Route::get('/', function () {
    return redirect('/app');
});

Route::get('/login', fn() => Inertia::render('Auth/Login'))->name('login');
Route::get('/register', fn() => Inertia::render('Auth/Register'));
Route::get('/logout', [AuthController::class, 'logout']);

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [RegisterController::class, 'register']);

// Frontend
Route::middleware('auth')->prefix('/app')->group(function () {
    Route::get('/', fn() => to_route('posts'))
        ->name('app');

    Route::get('/creators', [ProfileController::class, 'index']);
    Route::get('/creators/{profile}', [ProfileController::class, 'show']);

    Route::get('/register-creator', fn() => Inertia::render('Creator/Register'));
    Route::get('/register-creator-success', fn() => Inertia::render('Creator/Success'));

    Route::get('/posts', [PostController::class, 'index'])
        ->name('posts');
    Route::get('/posts/{post}', [PostController::class, 'show']);
    Route::get('/create-post', fn() => Inertia::render('Post/Create'));
});

// APIs
Route::middleware('auth')->group(function () {
    Route::get('/auth/me', [AuthController::class, 'me']);
    Route::post('/profiles/register', [ProfileController::class, 'register']);

    Route::get('/profiles', [ProfileController::class, 'index']);
    Route::patch('/profiles/{profile}/follow', [ProfileController::class, 'follow']);
    Route::post('/profiles/{profile}/subscribe', [ProfileController::class, 'subscribe']);

    Route::post('/posts', [PostController::class, 'store']);
});

Route::get('auth/social-login/{provider}/redirect', [AuthController::class, 'socialLogin']);
Route::get('auth/social-login/{provider}/callback', [AuthController::class, 'socialLoginCallback']);