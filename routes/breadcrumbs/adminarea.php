<?php

declare(strict_types=1);

use Cortex\Auth\Models\Admin;
use Cortex\Auth\Models\Member;
use Cortex\Auth\Models\Manager;
use Cortex\OAuth\Models\Client;
use Diglactic\Breadcrumbs\Breadcrumbs;
use Diglactic\Breadcrumbs\Generator;

Breadcrumbs::register('adminarea.cortex.auth.admins.clients', function (Generator $breadcrumbs, Admin $admin) {
    $breadcrumbs->parent('adminarea.cortex.auth.admins.index');
    $breadcrumbs->push(strip_tags($admin->username), route('adminarea.cortex.auth.admins.edit', ['admin' => $admin]));
    $breadcrumbs->push(trans('cortex/oauth::common.clients'), route('adminarea.cortex.auth.admins.clients', ['admin' => $admin]));
});

Breadcrumbs::register('adminarea.cortex.auth.admins.auth_codes', function (Generator $breadcrumbs, Admin $admin) {
    $breadcrumbs->parent('adminarea.cortex.auth.admins.index');
    $breadcrumbs->push(strip_tags($admin->username), route('adminarea.cortex.auth.admins.edit', ['admin' => $admin]));
    $breadcrumbs->push(trans('cortex/oauth::common.auth_codes'), route('adminarea.cortex.auth.admins.auth_codes', ['admin' => $admin]));
});

Breadcrumbs::register('adminarea.cortex.auth.admins.access_tokens', function (Generator $breadcrumbs, Admin $admin) {
    $breadcrumbs->parent('adminarea.cortex.auth.admins.index');
    $breadcrumbs->push(strip_tags($admin->username), route('adminarea.cortex.auth.admins.edit', ['admin' => $admin]));
    $breadcrumbs->push(trans('cortex/oauth::common.access_tokens'), route('adminarea.cortex.auth.admins.access_tokens', ['admin' => $admin]));
});

Breadcrumbs::register('adminarea.cortex.auth.managers.clients', function (Generator $breadcrumbs, Manager $manager) {
    $breadcrumbs->parent('adminarea.cortex.auth.managers.index');
    $breadcrumbs->push(strip_tags($manager->username), route('adminarea.cortex.auth.managers.edit', ['manager' => $manager]));
    $breadcrumbs->push(trans('cortex/oauth::common.clients'), route('adminarea.cortex.auth.managers.clients', ['manager' => $manager]));
});

Breadcrumbs::register('adminarea.cortex.auth.managers.auth_codes', function (Generator $breadcrumbs, Manager $manager) {
    $breadcrumbs->parent('adminarea.cortex.auth.managers.index');
    $breadcrumbs->push(strip_tags($manager->username), route('adminarea.cortex.auth.managers.edit', ['manager' => $manager]));
    $breadcrumbs->push(trans('cortex/oauth::common.auth_codes'), route('adminarea.cortex.auth.managers.auth_codes', ['manager' => $manager]));
});

Breadcrumbs::register('adminarea.cortex.auth.managers.access_tokens', function (Generator $breadcrumbs, Manager $manager) {
    $breadcrumbs->parent('adminarea.cortex.auth.managers.index');
    $breadcrumbs->push(strip_tags($manager->username), route('adminarea.cortex.auth.managers.edit', ['manager' => $manager]));
    $breadcrumbs->push(trans('cortex/oauth::common.access_tokens'), route('adminarea.cortex.auth.managers.access_tokens', ['manager' => $manager]));
});

Breadcrumbs::register('adminarea.cortex.auth.members.clients', function (Generator $breadcrumbs, Member $member) {
    $breadcrumbs->parent('adminarea.cortex.auth.members.index');
    $breadcrumbs->push(strip_tags($member->username), route('adminarea.cortex.auth.members.edit', ['member' => $member]));
    $breadcrumbs->push(trans('cortex/oauth::common.clients'), route('adminarea.cortex.auth.members.clients', ['member' => $member]));
});

Breadcrumbs::register('adminarea.cortex.auth.members.auth_codes', function (Generator $breadcrumbs, Member $member) {
    $breadcrumbs->parent('adminarea.cortex.auth.members.index');
    $breadcrumbs->push(strip_tags($member->username), route('adminarea.cortex.auth.members.edit', ['member' => $member]));
    $breadcrumbs->push(trans('cortex/oauth::common.auth_codes'), route('adminarea.cortex.auth.members.auth_codes', ['member' => $member]));
});

Breadcrumbs::register('adminarea.cortex.auth.members.access_tokens', function (Generator $breadcrumbs, Member $member) {
    $breadcrumbs->parent('adminarea.cortex.auth.members.index');
    $breadcrumbs->push(strip_tags($member->username), route('adminarea.cortex.auth.members.edit', ['member' => $member]));
    $breadcrumbs->push(trans('cortex/oauth::common.access_tokens'), route('adminarea.cortex.auth.members.access_tokens', ['member' => $member]));
});

Breadcrumbs::register('adminarea.cortex.oauth.clients.index', function (Generator $breadcrumbs) {
    $breadcrumbs->push('<i class="fa fa-dashboard"></i> '.config('app.name'), route('adminarea.home'));
    $breadcrumbs->push(trans('cortex/oauth::common.clients'), route('adminarea.cortex.oauth.clients.index'));
});

Breadcrumbs::register('adminarea.cortex.oauth.clients.create', function (Generator $breadcrumbs) {
    $breadcrumbs->parent('adminarea.cortex.oauth.clients.index');
    $breadcrumbs->push(trans('cortex/oauth::common.create_client'), route('adminarea.cortex.oauth.clients.create'));
});

Breadcrumbs::register('adminarea.cortex.oauth.clients.edit', function (Generator $breadcrumbs, Client $client) {
    $breadcrumbs->parent('adminarea.cortex.oauth.clients.index');
    $breadcrumbs->push(strip_tags($client->name), route('adminarea.cortex.oauth.clients.edit', ['client' => $client]));
});

Breadcrumbs::register('adminarea.cortex.oauth.clients.auth_codes', function (Generator $breadcrumbs, Client $client) {
    $breadcrumbs->parent('adminarea.cortex.oauth.clients.edit', $client);
    $breadcrumbs->push(trans('cortex/oauth::common.auth_codes'), route('adminarea.cortex.oauth.clients.auth_codes', ['client' => $client]));
});

Breadcrumbs::register('adminarea.cortex.oauth.clients.access_tokens', function (Generator $breadcrumbs, Client $client) {
    $breadcrumbs->parent('adminarea.cortex.oauth.clients.edit', $client);
    $breadcrumbs->push(trans('cortex/oauth::common.access_tokens'), route('adminarea.cortex.oauth.clients.access_tokens', ['client' => $client]));
});
