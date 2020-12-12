<?php

declare(strict_types=1);

use Cortex\OAuth\Models\Client;
use Rinvex\Menus\Models\MenuGenerator;

if ($user = auth()->guard(app('request.guard'))->user()) {
    Menu::register('frontarea.cortex.auth.account.sidebar', function (MenuGenerator $menu) {
        $menu->route(['frontarea.cortex.oauth.clients.index'], trans('cortex/oauth::common.clients'), null, 'fa fa-user')->activateOnRoute('frontarea.cortex.oauth.clients');
    });
}

Menu::register('frontarea.cortex.oauth.clients.tabs', function (MenuGenerator $menu, Client $client) {
    $menu->route(['frontarea.cortex.oauth.clients.create'], trans('cortex/oauth::common.create_client'))->if(Route::is('frontarea.cortex.oauth.clients.create'));
    $menu->route(['frontarea.cortex.oauth.clients.edit', ['client' => $client]], trans('cortex/oauth::common.details'))->if($client->exists);
    $menu->route(['frontarea.cortex.oauth.clients.auth_codes', ['client' => $client]], trans('cortex/oauth::common.auth_codes'))->if($client->exists);
    $menu->route(['frontarea.cortex.oauth.clients.access_tokens', ['client' => $client]], trans('cortex/oauth::common.access_tokens'))->if($client->exists);
});
