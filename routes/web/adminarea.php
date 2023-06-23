<?php

declare(strict_types=1);

use Cortex\Oauth\Http\Controllers\Adminarea\ClientsController;
use Cortex\Oauth\Http\Controllers\Adminarea\AuthorizationController;

Route::domain('{adminarea}')->group(function () {
    Route::name('adminarea.')
         ->middleware(['web', 'nohttpcache', 'can:access-adminarea'])
         ->prefix(route_prefix('adminarea'))->group(function () {

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

             Route::name('cortex.auth.')->group(function () {

                // Admin clients Routes
                 Route::name('admins.')->prefix('admins')->group(function () {
                     Route::get('{admin}/clients')->name('clients')->uses([ClientsController::class, 'clientsForUser']);
                     Route::get('{admin}/auth-codes')->name('auth_codes')->uses([ClientsController::class, 'authCodesForUser']);
                     Route::get('{admin}/access-tokens')->name('access_tokens')->uses([ClientsController::class, 'accessTokensForUser']);
                 });

                 // Member clients Routes
                 Route::name('members.')->prefix('members')->group(function () {
                     Route::get('{member}/clients')->name('clients')->uses([ClientsController::class, 'clientsForUser']);
                     Route::get('{member}/auth-codes')->name('auth_codes')->uses([ClientsController::class, 'authCodesForUser']);
                     Route::get('{member}/access-tokens')->name('access_tokens')->uses([ClientsController::class, 'accessTokensForUser']);
                 });
             });
         });
});
