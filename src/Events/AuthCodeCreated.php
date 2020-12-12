<?php

declare(strict_types=1);

namespace Cortex\OAuth\Events;

use Cortex\OAuth\Models\AuthCode;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class AuthCodeCreated implements ShouldBroadcast
{
    use InteractsWithSockets;
    use SerializesModels;
    use Dispatchable;

    /**
     * The name of the queue on which to place the event.
     *
     * @var string
     */
    public $broadcastQueue = 'events';

    /**
     * The model instance passed to this event.
     *
     * @var \Cortex\OAuth\Models\AuthCode
     */
    public AuthCode $model;

    /**
     * Create a new event instance.
     *
     * @param \Cortex\OAuth\Models\AuthCode $authCode
     */
    public function __construct(AuthCode $authCode)
    {
        $this->model = $authCode;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|\Illuminate\Broadcasting\Channel[]
     */
    public function broadcastOn()
    {
        return [
            new PrivateChannel('cortex.oauth.auth_codes.index'),
        ];
    }

    /**
     * The event's broadcast name.
     *
     * @return string
     */
    public function broadcastAs()
    {
        return 'auth_code.created';
    }
}
