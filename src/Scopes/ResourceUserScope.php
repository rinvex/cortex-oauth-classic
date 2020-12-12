<?php

declare(strict_types=1);

namespace Cortex\OAuth\Scopes;

use Yajra\DataTables\Contracts\DataTableScope;

class ResourceUserScope implements DataTableScope
{
    /**
     * The user id.
     *
     * @var int
     */
    protected $userId;

    /**
     * The provider.
     *
     * @var string
     */
    protected $provider;

    /**
     * Create a new controller instance.
     *
     * @param  int $userId
     * @param  string $provider
     */
    public function __construct(int $userId, string $provider)
    {
        $this->userId = $userId;
        $this->provider = $provider;
    }

    public function apply($query)
    {
        return $query->where('user_id', $this->userId)
                     ->where('provider', $this->provider);
    }
}
