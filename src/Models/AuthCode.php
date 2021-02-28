<?php

declare(strict_types=1);

namespace Cortex\OAuth\Models;

use Cortex\Foundation\Traits\Auditable;
use Rinvex\Support\Traits\HasTimezones;
use Cortex\OAuth\Events\AuthCodeCreated;
use Cortex\OAuth\Events\AuthCodeDeleted;
use Cortex\OAuth\Events\AuthCodeUpdated;
use Cortex\OAuth\Events\AuthCodeRestored;
use Rinvex\OAuth\Models\AuthCode as BaseAuthCode;

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
