<?php

declare(strict_types=1);


Route::middleware(['web'])->get('adminarea/oauth/redirect', function (\Illuminate\Http\Request $request) {
    $request->session()->put('state', $state = \Str::random(40));

    $query = http_build_query([
        'client_id' => '51',
        'redirect_uri' => 'http://cortex.rinvex.test/adminarea/oauth/callback',
        'response_type' => 'code',
        'scope' => 'place-orders check-status',
        'state' => $state,
    ]);

    return redirect('http://cortex.rinvex.test/adminarea/oauth/authorize?'.$query);
});

Route::middleware(['web'])->get('adminarea/oauth/callback', function (\Illuminate\Http\Request $request) {
    $state = $request->session()->pull('state');

    throw_unless(
        strlen($state) > 0 && $state === $request->state,
        InvalidArgumentException::class
    );

    //dd($request->code);
    return redirect('http://cortex.rinvex.test/adminarea/oauth/token?'.http_build_query([
            'grant_type' => 'authorization_code',
            'client_id' => '51',
            'client_secret' => 'bLGQa2fTqzVSonJvyT5CzHDD1JNEUevUm2esqVIy',
            'redirect_uri' => 'http://cortex.rinvex.test/adminarea/oauth/callback',
            'code' => $request->code,
        ]));

    $http = new GuzzleHttp\Client;

    $response = $http->post('http://cortex.rinvex.test/oauth/token', [
        'form_params' => [
            'grant_type' => 'authorization_code',
            'client_id' => '48',
            'client_secret' => 'bLGQa2fTqzVSonJvyT5CzHDD1JNEUevUm2esqVIy',
            'redirect_uri' => 'http://cortex.rinvex.test/callback',
            'code' => $request->code,
        ],
    ]);

    return json_decode((string) $response->getBody(), true);
});


Route::domain(domain())->group(function () {
    Route::name('adminarea.')
         ->namespace('Cortex\OAuth\Http\Controllers\Adminarea')
         ->middleware(['web', 'nohttpcache', 'can:access-adminarea'])
         ->prefix(config('cortex.foundation.route.locale_prefix') ? '{locale}/'.config('cortex.foundation.route.prefix.adminarea') : config('cortex.foundation.route.prefix.adminarea'))->group(function () {

            // Register OAuth Routes
            Route::name('cortex.oauth.')->group(function () {

                // Authorization process
                Route::prefix('oauth')->group(function () {
                    Route::get('authorize')->name('authorizations.authorize')->uses('AuthorizationController@authorizeRequest');
                    Route::post('authorize')->name('authorizations.approve')->uses('AuthorizationController@approve');
                    Route::delete('authorize')->name('authorizations.deny')->uses('AuthorizationController@deny');
                    Route::get('scopes')->name('authorizations.scopes')->uses('AuthorizationController@scopes');
                    Route::get('token')->name('authorizations.token')->uses('AuthorizationController@issueToken');
                    Route::post('token/refresh')->name('authorizations.token.refresh')->uses('AuthorizationController@refreshToken');
                });

                // Managing clients, auth codes, and access tokens
                Route::match(['get', 'post'], 'clients')->name('clients.index')->uses('ClientsController@index');
                Route::get('clients/create')->name('clients.create')->uses('ClientsController@create');
                Route::post('clients/create')->name('clients.store')->uses('ClientsController@store');
                Route::get('clients/{client}/edit')->name('clients.edit')->uses('ClientsController@edit');
                Route::put('clients/{client}/edit')->name('clients.update')->uses('ClientsController@update');
                Route::put('clients/{client}')->name('clients.revoke')->uses('ClientsController@revoke');
                Route::delete('clients/{client}')->name('clients.destroy')->uses('ClientsController@destroy');
                Route::match(['get', 'post'], 'clients/{client}/auth-codes')->name('clients.auth_codes')->uses('ClientsController@authCodes');
                Route::match(['get', 'post'], 'clients/{client}/access-tokens')->name('clients.access_tokens')->uses('ClientsController@accessTokens');

            });

            Route::name('cortex.auth.')->group(function () {

                // Admin clients Routes
                Route::name('admins.')->prefix('admins')->group(function () {
                    Route::get('{admin}/clients')->name('clients')->uses('ClientsController@clientsForUser');
                    Route::get('{admin}/auth-codes')->name('auth_codes')->uses('ClientsController@authCodesForUser');
                    Route::get('{admin}/access-tokens')->name('access_tokens')->uses('ClientsController@accessTokensForUser');
                });

                // Manager clients Routes
                Route::name('managers.')->prefix('managers')->group(function () {
                    Route::get('{manager}/clients')->name('clients')->uses('ClientsController@clientsForUser');
                    Route::get('{manager}/auth-codes')->name('auth_codes')->uses('ClientsController@authCodesForUser');
                    Route::get('{manager}/access-tokens')->name('access_tokens')->uses('ClientsController@accessTokensForUser');
                });

                // Member clients Routes
                Route::name('members.')->prefix('members')->group(function () {
                    Route::get('{member}/clients')->name('clients')->uses('ClientsController@clientsForUser');
                    Route::get('{member}/auth-codes')->name('auth_codes')->uses('ClientsController@authCodesForUser');
                    Route::get('{member}/access-tokens')->name('access_tokens')->uses('ClientsController@accessTokensForUser');
                });

            });

        });
});
