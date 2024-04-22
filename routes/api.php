<?php

use App\Http\Controllers\Api\V1\CompanyController;
use App\Http\Controllers\Api\V1\ContactController;
use App\Http\Controllers\Api\V1\NoteController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'v1'], function ($router) {
    $router->apiResource('companies', CompanyController::class)->only('index', 'store');
    $router->get('companies/search', [CompanyController::class, 'search'])->name('companies.search');
    $router->patch('companies/{company}/add-contact', [CompanyController::class, 'addContact'])->name('companies.add-contact');
    $router->get('companies/{company}/contacts', [CompanyController::class, 'contacts'])->name('companies.contacts');
    $router->apiResource('contacts', ContactController::class)->only('index', 'store', 'show', 'update');
    $router->post('notes', [NoteController::class, 'store'])->name('contacts.notes.create');
});
