<?php

declare(strict_types=1);

namespace Cortex\Oauth\DataTables\Frontarea;

use Cortex\Oauth\Models\AuthCode;
use Cortex\Oauth\Scopes\ResourceUserScope;
use Cortex\Oauth\Transformers\AuthCodeTransformer;
use Cortex\Foundation\DataTables\AbstractDataTable;

class AuthCodesDataTable extends AbstractDataTable
{
    /**
     * {@inheritdoc}
     */
    protected $model = AuthCode::class;

    /**
     * {@inheritdoc}
     */
    protected $transformer = AuthCodeTransformer::class;

    /**
     * Set action buttons.
     *
     * @var mixed
     */
    protected $buttons = [
        'create' => false,
        'import' => false,
        'print' => false,
        'export' => false,
        'revoke' => true,
    ];

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns(): array
    {
        return [
            'id' => ['checkboxes' => json_decode('{"selectRow": true}'), 'exportable' => false, 'printable' => false],
            'identifier' => ['title' => trans('cortex/oauth::common.id'), 'data' => 'id', 'responsivePriority' => 0],
            'user' => ['title' => trans('cortex/oauth::common.user'), 'render' => $this->getUserLink(), 'visible' => $this->attributes['show_user'] ?? true],
            'client' => ['title' => trans('cortex/oauth::common.client'), 'render' => $this->getClientLink(), 'visible' => $this->attributes['show_client'] ?? true],
            'abilities' => ['title' => trans('cortex/oauth::common.abilities')],
            'is_revoked' => ['title' => trans('cortex/oauth::common.is_revoked')],
            'expires_at' => ['title' => trans('cortex/oauth::common.expires_at'), 'render' => "moment(data).format('YYYY-MM-DD, hh:mm:ss A')"],
            'created_at' => ['title' => trans('cortex/oauth::common.created_at'), 'render' => "moment(data).format('YYYY-MM-DD, hh:mm:ss A')"],
            'updated_at' => ['title' => trans('cortex/oauth::common.updated_at'), 'render' => "moment(data).format('YYYY-MM-DD, hh:mm:ss A')"],
        ];
    }

    /**
     * Get client link.
     *
     * @return array
     */
    protected function getUserLink(): string
    {
        return config('cortex.foundation.route.locale_prefix')
            ? '"<a href=\""+routes.route(\'frontarea.cortex.auth.\'+pluralize.plural(full.user_type)+\'.edit\', {[full.user_type]: full.user.data.id, locale: \''.$this->request()->segment(1).'\'})+"\">"+full.user.data.username+"</a>"'
            : '"<a href=\""+routes.route(\'frontarea.cortex.auth.\'+pluralize.plural(full.user_type)+\'.edit\', {[full.user_type]: full.user.data.id})+"\">"+full.user.data.username+"</a>"';
    }

    /**
     * Get client link.
     *
     * @return array
     */
    protected function getClientLink(): string
    {
        return config('cortex.foundation.route.locale_prefix')
            ? '"<a href=\""+routes.route(\'frontarea.cortex.oauth.clients.edit\', {client: full.client.data.id, locale: \''.$this->request()->segment(1).'\'})+"\">"+full.client.data.name+"</a>"'
            : '"<a href=\""+routes.route(\'frontarea.cortex.oauth.clients.edit\', {client: full.client.data.id})+"\">"+full.client.data.name+"</a>"';
    }

    /**
     * Add scopes to the datatable.
     *
     * @return $this
     */
    public function scope()
    {
        return $this->addScope(new ResourceUserScope($this->request()->user()));
    }
}
