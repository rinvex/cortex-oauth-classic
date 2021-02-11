<?php

declare(strict_types=1);

namespace Cortex\OAuth\Scopes;

use Cortex\Auth\Models\User;
use Yajra\DataTables\Contracts\DataTableScope;

class ResourceUserScope implements DataTableScope
{
    /**
     * The user model object.
     *
     * @var \Cortex\Auth\Models\User
     */
    protected $user;

    /**
     * Create a new controller instance.
     *
     * @param \Cortex\Auth\Models\User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function apply($query)
    {
        return $query->where('user_id', $this->user->getAuthIdentifier())
                     ->where('provider', $this->user->getMorphClass());
    }
}
