<?php

declare(strict_types=1);

namespace Cortex\OAuth\Models;

use Cortex\Foundation\Traits\Auditable;
use Rinvex\Support\Traits\HasTimezones;
use Cortex\OAuth\Events\AccessTokenCreated;
use Cortex\OAuth\Events\AccessTokenDeleted;
use Cortex\OAuth\Events\AccessTokenUpdated;
use Cortex\OAuth\Events\AccessTokenRestored;
use Rinvex\OAuth\Models\AccessToken as BaseAccessToken;

class AccessToken extends BaseAccessToken
{
    use Auditable;
    use HasTimezones;

    /**
     * The event map for the model.
     *
     * @var array
     */
    protected $dispatchesEvents = [
        'created' => AccessTokenCreated::class,
        'updated' => AccessTokenUpdated::class,
        'deleted' => AccessTokenDeleted::class,
        'restored' => AccessTokenRestored::class,
    ];
}
