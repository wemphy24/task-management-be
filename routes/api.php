<?php

use App\Http\Controllers\API\RoleController;
use App\Http\Controllers\API\TaskController;
use App\Http\Controllers\API\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

// Route::post('login', [UserController::class, 'login']);
// Route::post('register', [UserController::class, 'register']);
// Route::post('logout', [UserController::class, 'logout'])->middleware('auth:sanctum');
// Route::get('user', [UserController::class, 'fetch'])->middleware('auth:sanctum');

// Route::get('role', [RoleController::class, 'fetch'])->middleware('auth:sanctum');
// Route::post('role', [RoleController::class, 'create'])->middleware('auth:sanctum');
// Route::post('role/update/{id}', [RoleController::class, 'update'])->middleware('auth:sanctum');

// Route::get('task', [TaskController::class, 'fetch'])->middleware('auth:sanctum');
// Route::post('task', [TaskController::class, 'create'])->middleware('auth:sanctum');
// Route::post('task/update/{id}', [TaskController::class, 'update'])->middleware('auth:sanctum');



// Auth API
Route::name('auth.')->group(function () {
    Route::post('/login', [UserController::class, 'login'])->name('login');
    Route::post('/register', [UserController::class, 'register'])->name('register');

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/logout', [UserController::class, 'logout'])->name('logout');
        Route::get('/user', [UserController::class, 'fetch'])->name('fetch');
        Route::get('/getalluser', [UserController::class, 'all'])->name('all');
    });
}); 

// Role API
Route::prefix('role')->middleware('auth:sanctum')->name('role.')->group(function () {
    Route::get('', [RoleController::class, 'fetch'])->name('fetch');
    Route::post('', [RoleController::class, 'create'])->name('create');
    Route::post('update/{id}', [RoleController::class, 'update'])->name('update');
    Route::delete('{id}', [RoleController::class, 'destroy'])->name('delete');
});

// Task API
Route::prefix('task')->middleware('auth:sanctum')->name('task.')->group(function () {
    Route::get('', [TaskController::class, 'fetch'])->name('fetch');
    Route::post('', [TaskController::class, 'create'])->name('create');
    Route::get('edit/{id}', [TaskController::class, 'edit'])->name('edit');
    Route::put('update/{id}', [TaskController::class, 'update'])->name('update');
});
