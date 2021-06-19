<?php

declare(strict_types=1);

namespace Cortex\Oauth\Models;

use Cortex\Foundation\Traits\Auditable;
use Rinvex\Support\Traits\HasTimezones;
use Cortex\Oauth\Events\RefreshTokenCreated;
use Cortex\Oauth\Events\RefreshTokenDeleted;
use Cortex\Oauth\Events\RefreshTokenUpdated;
use Cortex\Oauth\Events\RefreshTokenRestored;
use Rinvex\Oauth\Models\RefreshToken as BaseRefreshToken;

class RefreshToken extends BaseRefreshToken
{
    use Auditable;
    use HasTimezones;

    /**
     * The event map for the model.
     *
     * @var array
     */
    protected $dispatchesEvents = [
        'created' => RefreshTokenCreated::class,
        'updated' => RefreshTokenUpdated::class,
        'deleted' => RefreshTokenDeleted::class,
        'restored' => RefreshTokenRestored::class,
    ];
}
