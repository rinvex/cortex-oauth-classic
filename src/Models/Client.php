<?php

declare(strict_types=1);

namespace Cortex\OAuth\Models;

use Cortex\OAuth\Events\ClientCreated;
use Cortex\OAuth\Events\ClientDeleted;
use Cortex\OAuth\Events\ClientUpdated;
use Cortex\Foundation\Traits\Auditable;
use Cortex\OAuth\Events\ClientRestored;
use Rinvex\Support\Traits\HashidsTrait;
use Rinvex\Support\Traits\HasTimezones;
use Spatie\Activitylog\Traits\LogsActivity;
use Rinvex\OAuth\Models\Client as BaseClient;
use Spatie\Activitylog\Traits\CausesActivity;

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
