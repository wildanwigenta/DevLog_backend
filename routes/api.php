
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\ArticleController;
use App\Http\Controllers\API\CategoryController;

Route::apiResource('article', ArticleController::class);
Route::apiResource('categories', CategoryController::class);