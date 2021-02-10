<?php

declare(strict_types=1);

namespace Cortex\OAuth\DataTables\Frontarea;

use Cortex\OAuth\Models\Client;
use Illuminate\Database\Eloquent\Builder;
use Cortex\OAuth\Scopes\ResourceUserScope;
use Cortex\OAuth\Transformers\ClientTransformer;
use Cortex\Foundation\DataTables\AbstractDataTable;

class ClientsDataTable extends AbstractDataTable
{
    /**
     * {@inheritdoc}
     */
    protected $model = Client::class;

    /**
     * {@inheritdoc}
     */
    protected $transformer = ClientTransformer::class;

    /**
     * Set action buttons.
     *
     * @var mixed
     */
    protected $buttons = [
        'create' => true,
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
            'name' => ['title' => trans('cortex/oauth::common.name'), 'render' => $this->getClientLink(), 'responsivePriority' => 0],
            'user' => ['title' => trans('cortex/oauth::common.user'), 'render' => $this->getUserLink(), 'orderable' => false, 'printable' => false, 'exportable' => false, 'visible' => $this->attributes['show_user'] ?? true],
            'grant_type' => ['title' => trans('cortex/oauth::common.grant_type')],
            'is_revoked' => ['title' => trans('cortex/oauth::common.is_revoked')],
            'created_at' => ['title' => trans('cortex/oauth::common.created_at'), 'render' => "moment(data).format('YYYY-MM-DD, hh:mm:ss A')"],
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
            ? '"<a href=\""+routes.route(\'frontarea.cortex.auth.\'+full.provider+\'.edit\', {[full.provider]: full.user.data.id, locale: \''.$this->request()->segment(1).'\'})+"\">"+full.user.data.username+"</a>"'
            : '"<a href=\""+routes.route(\'frontarea.cortex.auth.\'+full.provider+\'.edit\', {[full.provider]: full.user.data.id})+"\">"+full.user.data.username+"</a>"';
    }

    /**
     * Get client link.
     *
     * @return array
     */
    protected function getClientLink(): string
    {
        return config('cortex.foundation.route.locale_prefix')
            ? '"<a href=\""+routes.route(\'frontarea.cortex.oauth.clients.edit\', {client: full.id, locale: \''.$this->request()->segment(1).'\'})+"\">"+data+"</a>"'
            : '"<a href=\""+routes.route(\'frontarea.cortex.oauth.clients.edit\', {client: full.id})+"\">"+data+"</a>"';
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
            ->orderColumn('name', 'name->"$.'.app()->getLocale().'" $1')
            ->filterColumn('user', function (Builder $builder, $keyword) {
                $builder->whereHasMorph('user', '*', function (Builder $builder) use ($keyword) {
                    $builder->where('username', 'like', "%{$keyword}%");
                });
            })
            ->make(true);
    }

    /**
     * Add scopes to the datatable.
     *
     * @return $this
     */
    public function scope()
    {
        return $this->addScope(new ResourceUserScope($this->request()->user(app('request.guard'))));
    }
}
