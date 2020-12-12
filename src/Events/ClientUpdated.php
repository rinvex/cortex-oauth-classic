<?php

declare(strict_types=1);

namespace Cortex\OAuth\Events;

use Cortex\OAuth\Models\Client;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class ClientUpdated implements ShouldBroadcast
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
     * @var \Cortex\OAuth\Models\Client
     */
    public Client $model;

    /**
     * Create a new event instance.
     *
     * @param \Cortex\OAuth\Models\Client $client
     */
    public function __construct(Client $client)
    {
        $this->model = $client;
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
        return 'client.updated';
    }
}
