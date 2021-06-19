<?php

declare(strict_types=1);

namespace Cortex\Oauth\Events;

use Cortex\Oauth\Models\AccessToken;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class AccessTokenRestored implements ShouldBroadcast
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
     * @var \Cortex\Oauth\Models\AccessToken
     */
    public AccessToken $model;

    /**
     * Create a new event instance.
     *
     * @param \Cortex\Oauth\Models\AccessToken $accessToken
     */
    public function __construct(AccessToken $accessToken)
    {
        $this->model = $accessToken;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|\Illuminate\Broadcasting\Channel[]
     */
    public function broadcastOn()
    {
        return [
            new PrivateChannel('cortex.oauth.access_tokens.index'),
            new PrivateChannel("cortex.oauth.access_tokens.{$this->model->getRouteKey()}"),
        ];
    }

    /**
     * The event's broadcast name.
     *
     * @return string
     */
    public function broadcastAs()
    {
        return 'access_token.restored';
    }
}
