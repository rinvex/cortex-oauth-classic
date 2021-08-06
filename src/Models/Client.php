<?php

declare(strict_types=1);

namespace Cortex\Oauth\Models;

use Spatie\Activitylog\LogOptions;
use Cortex\Oauth\Events\ClientCreated;
use Cortex\Oauth\Events\ClientDeleted;
use Cortex\Oauth\Events\ClientUpdated;
use Cortex\Foundation\Traits\Auditable;
use Cortex\Oauth\Events\ClientRestored;
use Rinvex\Support\Traits\HashidsTrait;
use Rinvex\Support\Traits\HasTimezones;
use Spatie\Activitylog\Traits\LogsActivity;
use Rinvex\Oauth\Models\Client as BaseClient;
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
     * Set sensible Activity Log Options.
     *
     * @return \Spatie\Activitylog\LogOptions
     */
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
                         ->logFillable()
                         ->logOnlyDirty()
                         ->dontSubmitEmptyLogs();
    }
}
