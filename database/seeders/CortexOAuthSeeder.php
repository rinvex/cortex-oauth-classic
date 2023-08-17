<?php

declare(strict_types=1);

namespace Cortex\Oauth\Database\Seeders;

use Illuminate\Database\Seeder;

class CortexOAuthSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $abilities = [

            ['name' => 'list', 'title' => 'List Clients', 'entity_type' => 'client'],
            ['name' => 'view', 'title' => 'View Clients', 'entity_type' => 'client'],
            ['name' => 'create', 'title' => 'Create Clients', 'entity_type' => 'client'],
            ['name' => 'update', 'title' => 'Update Clients', 'entity_type' => 'client'],
            ['name' => 'revoke', 'title' => 'Revoke Clients', 'entity_type' => 'client'],
            ['name' => 'delete', 'title' => 'Delete Clients', 'entity_type' => 'client'],

            ['name' => 'list', 'title' => 'List Auth Codes', 'entity_type' => 'auth_code'],
            ['name' => 'view', 'title' => 'View Auth Codes', 'entity_type' => 'auth_code'],
            ['name' => 'import', 'title' => 'Import Auth Codes', 'entity_type' => 'auth_code'],
            ['name' => 'export', 'title' => 'Export Auth Codes', 'entity_type' => 'auth_code'],
            ['name' => 'create', 'title' => 'Create Auth Codes', 'entity_type' => 'auth_code'],
            ['name' => 'delete', 'title' => 'Delete Auth Codes', 'entity_type' => 'auth_code'],

            ['name' => 'list', 'title' => 'List Access Tokens', 'entity_type' => 'access_token'],
            ['name' => 'view', 'title' => 'View Access Tokens', 'entity_type' => 'access_token'],
            ['name' => 'import', 'title' => 'Import Access Tokens', 'entity_type' => 'access_token'],
            ['name' => 'export', 'title' => 'Export Access Tokens', 'entity_type' => 'access_token'],
            ['name' => 'create', 'title' => 'Create Access Tokens', 'entity_type' => 'access_token'],
            ['name' => 'delete', 'title' => 'Delete Access Tokens', 'entity_type' => 'access_token'],

            ['name' => 'list', 'title' => 'List Refresh Tokens', 'entity_type' => 'refresh_token'],
            ['name' => 'view', 'title' => 'View Refresh Tokens', 'entity_type' => 'refresh_token'],
            ['name' => 'import', 'title' => 'Import Refresh Tokens', 'entity_type' => 'refresh_token'],
            ['name' => 'export', 'title' => 'Export Refresh Tokens', 'entity_type' => 'refresh_token'],
            ['name' => 'create', 'title' => 'Create Refresh Tokens', 'entity_type' => 'refresh_token'],
            ['name' => 'delete', 'title' => 'Delete Refresh Tokens', 'entity_type' => 'refresh_token'],

        ];

        collect($abilities)->each(function (array $ability) {
            app('cortex.auth.ability')->firstOrCreate([
                'name' => $ability['name'],
                'entity_type' => $ability['entity_type'],
            ], $ability);
        });
    }
}
