<?php

declare(strict_types=1);

namespace Cortex\Oauth\Models;

use Cortex\Foundation\Traits\Auditable;
use Rinvex\Support\Traits\HasTimezones;
use Cortex\Oauth\Events\AccessTokenCreated;
use Cortex\Oauth\Events\AccessTokenDeleted;
use Cortex\Oauth\Events\AccessTokenUpdated;
use Cortex\Oauth\Events\AccessTokenRestored;
use Rinvex\Oauth\Models\AccessToken as BaseAccessToken;

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
