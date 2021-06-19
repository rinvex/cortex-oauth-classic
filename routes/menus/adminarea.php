<?php

declare(strict_types=1);

use Cortex\Auth\Models\Admin;
use Cortex\Auth\Models\Member;
use Cortex\Auth\Models\Manager;
use Cortex\Oauth\Models\Client;
use Rinvex\Menus\Models\MenuItem;
use Rinvex\Menus\Models\MenuGenerator;

Menu::register('adminarea.sidebar', function (MenuGenerator $menu) {
    $menu->findByTitleOrAdd(trans('cortex/oauth::common.oauth'), 10, 'fa fa-lock', 'header', [], function (MenuItem $dropdown) {
        $dropdown->route(['adminarea.cortex.oauth.clients.index'], trans('cortex/oauth::common.clients'), 10, 'fa fa-user')->ifCan('list', app('rinvex.oauth.client'))->activateOnRoute('adminarea.cortex.oauth.clients');
    });
});

Menu::register('adminarea.cortex.auth.admins.tabs', function (MenuGenerator $menu, Admin $admin) {
    $menu->route(['adminarea.cortex.auth.admins.clients', ['admin' => $admin]], trans('cortex/oauth::common.clients'))->ifCan('list', app('rinvex.oauth.client'))->if($admin->exists);
    $menu->route(['adminarea.cortex.auth.admins.auth_codes', ['admin' => $admin]], trans('cortex/oauth::common.auth_codes'))->ifCan('list', app('rinvex.oauth.auth_code'))->if($admin->exists);
    $menu->route(['adminarea.cortex.auth.admins.access_tokens', ['admin' => $admin]], trans('cortex/oauth::common.access_tokens'))->ifCan('list', app('rinvex.oauth.access_token'))->if($admin->exists);
});

Menu::register('adminarea.cortex.auth.managers.tabs', function (MenuGenerator $menu, Manager $manager) {
    $menu->route(['adminarea.cortex.auth.managers.clients', ['manager' => $manager]], trans('cortex/oauth::common.clients'))->ifCan('list', app('rinvex.oauth.client'))->if($manager->exists);
    $menu->route(['adminarea.cortex.auth.managers.auth_codes', ['manager' => $manager]], trans('cortex/oauth::common.auth_codes'))->ifCan('list', app('rinvex.oauth.auth_code'))->if($manager->exists);
    $menu->route(['adminarea.cortex.auth.managers.access_tokens', ['manager' => $manager]], trans('cortex/oauth::common.access_tokens'))->ifCan('list', app('rinvex.oauth.access_token'))->if($manager->exists);
});

Menu::register('adminarea.cortex.auth.members.tabs', function (MenuGenerator $menu, Member $member) {
    $menu->route(['adminarea.cortex.auth.members.clients', ['member' => $member]], trans('cortex/oauth::common.clients'))->ifCan('list', app('rinvex.oauth.client'))->if($member->exists);
    $menu->route(['adminarea.cortex.auth.members.auth_codes', ['member' => $member]], trans('cortex/oauth::common.auth_codes'))->ifCan('list', app('rinvex.oauth.auth_code'))->if($member->exists);
    $menu->route(['adminarea.cortex.auth.members.access_tokens', ['member' => $member]], trans('cortex/oauth::common.access_tokens'))->ifCan('list', app('rinvex.oauth.access_token'))->if($member->exists);
});

Menu::register('adminarea.cortex.oauth.clients.tabs', function (MenuGenerator $menu, Client $client) {
    $menu->route(['adminarea.cortex.oauth.clients.create'], trans('cortex/oauth::common.create_client'))->ifCan('create', $client)->if(Route::is('adminarea.cortex.oauth.clients.create'));
    $menu->route(['adminarea.cortex.oauth.clients.edit', ['client' => $client]], trans('cortex/oauth::common.details'))->if($client->exists);
    $menu->route(['adminarea.cortex.oauth.clients.auth_codes', ['client' => $client]], trans('cortex/oauth::common.auth_codes'))->if($client->exists);
    $menu->route(['adminarea.cortex.oauth.clients.access_tokens', ['client' => $client]], trans('cortex/oauth::common.access_tokens'))->if($client->exists);
});
