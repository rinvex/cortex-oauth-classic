<?php

declare(strict_types=1);

namespace Cortex\Oauth\Events;

use Cortex\Oauth\Models\Client;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class ClientDeleted implements ShouldBroadcast
{
    use InteractsWithSockets;
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
     * @var \Cortex\Oauth\Models\Client
     */
    public Client $model;

    /**
     * Create a new event instance.
     *
     * @param \Cortex\Oauth\Models\Client $client
     */
    public function __construct(Client $client)
    {
        $this->model = $client->withoutRelations();
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|\Illuminate\Broadcasting\Channel[]
     */
    public function broadcastOn()
    {
        return [
            new PrivateChannel('cortex.oauth.clients.index'),
            new PrivateChannel("cortex.oauth.clients.{$this->model->getRouteKey()}"),
        ];
    }

    /**
     * The event's broadcast name.
     *
     * @return string
     */
    public function broadcastAs()
    {
        return 'client.deleted';
    }
}
