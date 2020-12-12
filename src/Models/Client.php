<?php

declare(strict_types=1);

namespace Cortex\OAuth\Models;

use Cortex\OAuth\Events\ClientCreated;
use Cortex\OAuth\Events\ClientDeleted;
use Cortex\OAuth\Events\ClientUpdated;
use Cortex\Foundation\Traits\Auditable;
use Rinvex\Support\Traits\HashidsTrait;
use Rinvex\Support\Traits\HasTimezones;
use Cortex\OAuth\Events\ClientRestored;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\Traits\CausesActivity;
use Rinvex\OAuth\Models\Client as BaseClient;

class Client extends BaseClient
{
    use Auditable;
    use HashidsTrait;
    use HasTimezones;
    use LogsActivity;
    use CausesActivity;

    /**
     * The event map for the model.
     *
     * @var array
     */
    protected $dispatchesEvents = [
        'created' => ClientCreated::class,
        'updated' => ClientUpdated::class,
        'deleted' => ClientDeleted::class,
        'restored' => ClientRestored::class,
    ];

    /**
     * Indicates whether to log only dirty attributes or all.
     *
     * @var bool
     */
    protected static $logOnlyDirty = true;

    /**
     * The attributes that are logged on change.
     *
     * @var array
     */
    protected static $logFillable = true;

    /**
     * The attributes that are ignored on change.
     *
     * @var array
     */
    protected static $ignoreChangedAttributes = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];
}
