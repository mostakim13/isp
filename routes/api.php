<?php

use App\Http\Controllers\Admin\ApiController;
use Illuminate\Support\Facades\Route;

Route::get('/subzones', [ApiController::class, 'get_subzones'])->name('api.subzones');
Route::get('/tjs', [ApiController::class, 'get_tjs'])->name('api.tjs');
Route::get('/cores', [ApiController::class, 'findAvailabelCore'])->name('api.cores');
Route::get('/splitters', [ApiController::class, 'get_splitters'])->name('api.splitters');
Route::get('/splitters-core', [ApiController::class, 'get_splitterscore'])->name('api.SplitterCore');
Route::get('/boxes', [ApiController::class, 'get_boxes'])->name('api.boxes');
Route::post('/tjs-for-new-client', [ApiController::class, 'get_tjs_for_new_clients'])->name('api.new_tj');
Route::post('/cores-for-new-client', [ApiController::class, 'get_cores_for_new_clients'])->name('api.new_cores');
Route::post('/splitter-for-new-client', [ApiController::class, 'get_splitters_for_new_clients'])->name('api.new_splitters');
// Route::get('/tjs', [ApiController::class, 'get_tjs'])->name('api.tjs');
// Route::get('/subzones', [ApiController::class, 'subzones'])->name('api.subzones');
// Route::middleware('auth:sanctum')->group(function () {
// });
