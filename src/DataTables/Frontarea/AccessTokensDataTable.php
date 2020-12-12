<?php

declare(strict_types=1);

namespace Cortex\OAuth\DataTables\Frontarea;

use Cortex\OAuth\Models\AccessToken;
use Cortex\OAuth\Scopes\ResourceUserScope;
use Cortex\Foundation\DataTables\AbstractDataTable;
use Cortex\OAuth\Transformers\AccessTokenTransformer;
use Illuminate\Database\Eloquent\Builder;

class AccessTokensDataTable extends AbstractDataTable
{
    /**
     * {@inheritdoc}
     */
    protected $model = AccessToken::class;

    /**
     * {@inheritdoc}
     */
    protected $transformer = AccessTokenTransformer::class;

    /**
     * Set action buttons.
     *
     * @var mixed
     */
    protected $buttons = [
        'create' => false,
        'import' => false,
        'create_popup' => false,

        'reset' => true,
        'reload' => true,
        'showSelected' => true,

        'print' => false,
        'export' => false,

        'bulkDelete' => true,
        'bulkActivate' => false,
        'bulkDeactivate' => false,
        'bulkRevoke' => true,

        'colvis' => true,
        'pageLength' => true,
    ];

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns(): array
    {
        return [
            'id' => ['checkboxes' => '{"selectRow": true}', 'exportable' => false, 'printable' => false],
            'identifier' => ['title' => trans('cortex/oauth::common.id'), 'data' => 'id'],
            'name' => ['title' => trans('cortex/oauth::common.name'), 'responsivePriority' => 0],
            'user' => ['title' => trans('cortex/oauth::common.user'), 'render' => $this->getUserLink(), 'visible' => $this->attributes['show_user'] ?? true],
            'client' => ['title' => trans('cortex/oauth::common.client'), 'render' => $this->getClientLink(), 'visible' => $this->attributes['show_client'] ?? true],
            'scopes' => ['title' => trans('cortex/oauth::common.scopes')],
            'is_revoked' => ['title' => trans('cortex/oauth::common.is_revoked')],
            'expires_at' => ['title' => trans('cortex/oauth::common.expires_at'), 'render' => "moment(data).format('YYYY-MM-DD, hh:mm:ss A')"],
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
            ? '"<a href=\""+routes.route(\'frontarea.\'+full.provider+\'s.edit\', {[full.provider]: full.user.data.id, locale: \''.$this->request()->segment(1).'\'})+"\">"+full.user.data.username+"</a>"'
            : '"<a href=\""+routes.route(\'frontarea.\'+full.provider+\'s.edit\', {[full.provider]: full.user.data.id})+"\">"+full.user.data.username+"</a>"';
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
        $userId = $this->request()->user(app('request.guard'))->getAuthIdentifier();
        $provider = $this->request()->user(app('request.guard'))->getMorphClass();

        return $this->addScope(new ResourceUserScope($userId, $provider));
    }

    /**
     * Display ajax response.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function ajax()
    {
        return datatables($this->query())
            ->setTransformer(app($this->transformer))
            ->filterColumn('user', function (Builder $builder, $keyword) {
                $builder->whereHasMorph('user', '*', function (Builder $builder) use ($keyword) {
                    $builder->where('username', 'like', "%{$keyword}%");
                });
            })
            ->filterColumn('client', function (Builder $builder, $keyword) {
                $builder->whereHas('client', function (Builder $builder) use ($keyword) {
                    $builder->where('name', 'like', "%{$keyword}%");
                });
            })
            ->make(true);
    }
}
