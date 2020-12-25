<?php

declare(strict_types=1);

namespace Cortex\OAuth\Models;

use Rinvex\Support\Traits\HasTimezones;
use Cortex\OAuth\Events\RefreshTokenCreated;
use Cortex\OAuth\Events\RefreshTokenDeleted;
use Cortex\OAuth\Events\RefreshTokenUpdated;
use Cortex\OAuth\Events\RefreshTokenRestored;
use Rinvex\OAuth\Models\RefreshToken as BaseRefreshToken;

class RefreshToken extends BaseRefreshToken
{
    use HasTimezones;

    /**
     * Obscure IDs in certain access areas.
     *
     * @var array
     */
    public $obscure = [
        'rotate' => false,
        'areas' => [],
    ];

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
