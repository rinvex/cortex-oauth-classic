<?php

declare(strict_types=1);

namespace Cortex\OAuth\Http\Controllers\Frontarea;

use Cortex\OAuth\Models\Client;
use Illuminate\Foundation\Http\FormRequest;
use Cortex\OAuth\DataTables\Frontarea\ClientsDataTable;
use Cortex\OAuth\DataTables\Frontarea\AuthCodesDataTable;
use Cortex\OAuth\Http\Requests\Frontarea\ClientFormRequest;
use Cortex\Foundation\Http\Controllers\AuthenticatedController;
use Cortex\OAuth\DataTables\Frontarea\AccessTokensDataTable;
use Cortex\OAuth\Http\Requests\Frontarea\ClientFormPostRequest;

class ClientsController extends AuthenticatedController
{
    /**
     * Get all of the clients for the authenticated user.
     *
     * @TODO: Add missing pusher to all needed datatables below.
     * @param  \Cortex\OAuth\DataTables\Frontarea\ClientsDataTable $clientsDataTable
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function index(ClientsDataTable $clientsDataTable)
    {
        return $clientsDataTable->with([
            'show_user' => false,
            'id' => 'frontarea-cortex-oauth-clients-index',
            'pusher' => ['entity' => 'client', 'channel' => 'cortex.oauth.clients.index'],
        ])->render('cortex/foundation::frontarea.pages.datatable-index');
    }

    /**
     * Get all of the auth codes for the given client.
     *
     * @param  \Cortex\OAuth\DataTables\Frontarea\AuthCodesDataTable $clientsDataTable
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function authCodes(Client $client, AuthCodesDataTable $clientsDataTable)
    {
        return $clientsDataTable->with([
            'show_client' => false,
            'tabs' => 'frontarea.cortex.oauth.clients.tabs',
            'id' => "frontarea-cortex-auth-users-{$client->getRouteKey()}-auth-codes",
        ])->render('cortex/foundation::frontarea.pages.datatable-tab');
    }

    /**
     * Get all of the access tokens for the given client.
     *
     * @param  \Cortex\OAuth\DataTables\Frontarea\AccessTokensDataTable $accessTokensDataTable
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\View\View
     */
    public function accessTokens(Client $client, AccessTokensDataTable $accessTokensDataTable)
    {
        return $accessTokensDataTable->with([
            'show_client' => false,
            'tabs' => 'frontarea.cortex.oauth.clients.tabs',
            'id' => "frontarea-cortex-auth-users-{$client->getRouteKey()}-access-tokens",
        ])->render('cortex/foundation::frontarea.pages.datatable-tab');
    }

    /**
     * Create new client.
     *
     * @param \Cortex\OAuth\Http\Requests\Frontarea\ClientFormRequest $request
     * @param \Cortex\OAuth\Models\Client $client
     *
     * @return \Illuminate\View\View
     */
    public function create(ClientFormRequest $request, Client $client)
    {
        return $this->form($request, $client);
    }

    /**
     * Edit given client.
     *
     * @param \Cortex\OAuth\Http\Requests\Frontarea\ClientFormRequest $request
     * @param \Cortex\OAuth\Models\Client $client
     *
     * @return \Illuminate\View\View
     */
    public function edit(ClientFormRequest $request, Client $client)
    {
        return $this->form($request, $client);
    }

    /**
     * Show client create/edit form.
     *
     * @param \Illuminate\Foundation\Http\FormRequest $request
     * @param \Cortex\OAuth\Models\Client $client
     *
     * @return \Illuminate\View\View
     */
    protected function form(FormRequest $request, Client $client)
    {
        $grantTypes = [
            'authorization_code' => trans('cortex/oauth::common.authorization_code'),
            'client_credentials' => trans('cortex/oauth::common.client_credentials'),
            'personal_access' => trans('cortex/oauth::common.personal_access'),
            'password' => trans('cortex/oauth::common.password'),
        ];

        return view('cortex/oauth::frontarea.pages.client', compact('client', 'grantTypes'));
    }

    /**
     * Store new client.
     *
     * @param \Cortex\OAuth\Http\Requests\Frontarea\ClientFormPostRequest $request
     * @param \Cortex\OAuth\Models\Client                             $client
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function store(ClientFormPostRequest $request, Client $client)
    {
        return $this->process($request, $client);
    }

    /**
     * Update given client.
     *
     * @param \Cortex\OAuth\Http\Requests\Frontarea\ClientFormPostRequest $request
     * @param \Cortex\OAuth\Models\Client                             $client
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function update(ClientFormPostRequest $request, Client $client)
    {
        return $this->process($request, $client);
    }

    /**
     * Process stored/updated client.
     *
     * @param \Illuminate\Foundation\Http\FormRequest $request
     * @param \Cortex\OAuth\Models\Client               $client
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    protected function process(FormRequest $request, Client $client)
    {
        // Prepare required input fields
        $data = $request->validated();

        // Save client
        $client->fill($data)->save();

        return intend([
            'url' => route('frontarea.cortex.oauth.clients.index'),
            'with' => ['success' => $client->wasRecentlyCreated
                ? trans('cortex/oauth::messages.client_created', ['identifier' => $client->getRouteKey(), 'secret_phrase' => $client->secret ? trans('cortex/oauth::messages.secret_phrase', ['secret' => $client->plainSecret]) : null])
                : trans('cortex/oauth::messages.client_updated', ['identifier' => $client->getRouteKey()])
            ],
        ]);
    }

    /**
     * Destroy given page.
     *
     * @param \Cortex\OAuth\Http\Requests\Frontarea\ClientFormRequest $request
     * @param \Cortex\OAuth\Models\Client $client
     *
     * @throws \Exception
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function destroy(ClientFormRequest $request, Client $client)
    {
        $client->delete();

        return intend([
            'url' => route('frontarea.cortex.oauth.clients.index'),
            'with' => ['warning' => trans('cortex/foundation::messages.resource_deleted', ['resource' => trans('cortex/oauth::common.client'), 'identifier' => $client->getRouteKey()])],
        ]);
    }

    /**
     * Revoke given page.
     *
     * @param \Cortex\OAuth\Http\Requests\Frontarea\ClientFormRequest $request
     * @param \Cortex\OAuth\Models\Client $client
     *
     * @throws \Exception
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function revoke(ClientFormRequest $request, Client $client)
    {
        $client->revoke();

        return intend([
            'url' => route('frontarea.cortex.oauth.clients.index'),
            'with' => ['warning' => trans('cortex/foundation::messages.resource_revoked', ['resource' => trans('cortex/oauth::common.client'), 'identifier' => $client->getRouteKey()])],
        ]);
    }
}
