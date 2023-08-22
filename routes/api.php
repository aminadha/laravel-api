<?php

use App\Http\Controllers\Api\V1\ActivateOrganization;
use App\Http\Controllers\API\V1\BranchesController;
use App\Http\Controllers\API\V1\OrganizationsController;
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

// http://localhost:8000/api/test

Route::get('/test', function () {
    return 'this is test page';
});

// organizations


Route::prefix('v1')->group(function () {

    // organizations
    Route::apiResource('organizations', OrganizationsController::class);
    Route::post('organizations/restore/{organization}', [OrganizationsController::class, 'restore']);
    Route::delete('organizations/force-delete/{organization}', [OrganizationsController::class, 'forceDelete']);

    Route::post('activate-organization', ActivateOrganization::class);

    // Route::get('organizations', [OrganizationsController::class, 'index']);
    // Route::get('organizations', [OrganizationsController::class, 'show']);
    // Route::post('organizations', [OrganizationsController::class, 'store']);
    // Route::put('organizations/{id}', [OrganizationsController::class, 'update']);
    // Route::patch('organizations/{id}', [OrganizationsController::class, 'update']);
    // Route::delete('organizations/{id}', [OrganizationsController::class, 'destroy']);

    Route::get('branches', [BranchesController::class, 'index']);
});
