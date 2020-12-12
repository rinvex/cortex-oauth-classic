<?php

declare(strict_types=1);

namespace Cortex\OAuth\Events;

use Cortex\OAuth\Models\RefreshToken;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class RefreshTokenRestored implements ShouldBroadcast
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
     * @var \Cortex\OAuth\Models\RefreshToken
     */
    public RefreshToken $model;

    /**
     * Create a new event instance.
     *
     * @param \Cortex\OAuth\Models\RefreshToken $refreshToken
     */
    public function __construct(RefreshToken $refreshToken)
    {
        $this->model = $refreshToken;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|\Illuminate\Broadcasting\Channel[]
     */
    public function broadcastOn()
    {
        return [
            new PrivateChannel('cortex.oauth.refresh_tokens.index'),
            new PrivateChannel("cortex.oauth.refresh_tokens.{$this->model->getRouteKey()}"),
        ];
    }

    /**
     * The event's broadcast name.
     *
     * @return string
     */
    public function broadcastAs()
    {
        return 'refresh_token.restored';
    }
}
