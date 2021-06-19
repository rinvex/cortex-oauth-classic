<?php

declare(strict_types=1);

namespace Cortex\Oauth\Models;

use Cortex\Foundation\Traits\Auditable;
use Rinvex\Support\Traits\HasTimezones;
use Cortex\Oauth\Events\AuthCodeCreated;
use Cortex\Oauth\Events\AuthCodeDeleted;
use Cortex\Oauth\Events\AuthCodeUpdated;
use Cortex\Oauth\Events\AuthCodeRestored;
use Rinvex\Oauth\Models\AuthCode as BaseAuthCode;

class AuthCode extends BaseAuthCode
{
    use Auditable;
    use HasTimezones;

    /**
     * The event map for the model.
     *
     * @var array
     */
    protected $dispatchesEvents = [
        'created' => AuthCodeCreated::class,
        'updated' => AuthCodeUpdated::class,
        'deleted' => AuthCodeDeleted::class,
        'restored' => AuthCodeRestored::class,
    ];
}
