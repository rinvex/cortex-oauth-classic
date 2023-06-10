<?php

declare(strict_types=1);

use Cortex\Oauth\Http\Controllers\Frontarea\ClientsController;
use Cortex\Oauth\Http\Controllers\Frontarea\AuthorizationController;

Route::domain('{frontarea}')->group(function () {
    Route::name('frontarea.')
         ->middleware(['web', 'auth'])
         ->prefix(route_prefix('frontarea'))->group(function () {
             // Register OAuth Routes
             Route::name('cortex.oauth.')->group(function () {
                 // Authorization process
                 Route::prefix('oauth')->group(function () {
                     Route::get('authorize')->name('authorize')->uses([AuthorizationController::class, 'authorizeRequest']);
                     Route::post('authorize')->name('approve')->uses([AuthorizationController::class, 'approve']);
                     Route::delete('authorize')->name('deny')->uses([AuthorizationController::class, 'deny']);
                     Route::post('token')->name('token')->uses([AuthorizationController::class, 'issueToken']);
                     Route::post('token/refresh')->name('token.refresh')->uses([AuthorizationController::class, 'refreshToken']);
                 });

                 // Managing clients, auth codes, and access tokens
                 Route::match(['get', 'post'], 'clients')->name('clients.index')->uses([ClientsController::class, 'index']);
                 Route::get('clients/create')->name('clients.create')->uses([ClientsController::class, 'create']);
                 Route::post('clients/create')->name('clients.store')->uses([ClientsController::class, 'store']);
                 Route::get('clients/{client}/edit')->name('clients.edit')->uses([ClientsController::class, 'edit']);
                 Route::put('clients/{client}/edit')->name('clients.update')->uses([ClientsController::class, 'update']);
                 Route::put('clients/{client}')->name('clients.revoke')->uses([ClientsController::class, 'revoke']);
                 Route::delete('clients/{client}')->name('clients.destroy')->uses([ClientsController::class, 'destroy']);
                 Route::match(['get', 'post'], 'clients/{client}/auth-codes')->name('clients.auth_codes')->uses([ClientsController::class, 'authCodes']);
                 Route::match(['get', 'post'], 'clients/{client}/access-tokens')->name('clients.access_tokens')->uses([ClientsController::class, 'accessTokens']);
             });
         });
});
