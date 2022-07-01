<?php

declare(strict_types=1);

namespace Cortex\Oauth\Transformers;

use Cortex\Oauth\Models\Client;
use Rinvex\Support\Traits\Escaper;
use League\Fractal\TransformerAbstract;

class ClientTransformer extends TransformerAbstract
{
    use Escaper;

    /**
     * List of resources to automatically include.
     *
     * @var array
     */
    protected array $defaultIncludes = [
        'user',
    ];

    /**
     * Transform client model.
     *
     * @param \Cortex\Oauth\Models\Client $client
     *
     * @throws \Exception
     *
     * @return array
     */
    public function transform(Client $client): array
    {
        return $this->escape([
            'id' => (string) $client->getRouteKey(),
            'name' => (string) $client->name,
            'user_type' => (string) $client->user_type,
            'grant_type' => (string) $client->grant_type,
            'is_revoked' => (bool) $client->is_revoked,
            'created_at' => (string) $client->created_at,
            'updated_at' => (string) $client->updated_at,
        ]);
    }

    /**
     * Include Author.
     *
     * @param \Cortex\Oauth\Models\Client $client
     *
     * @return \League\Fractal\Resource\Item
     */
    public function includeUser(Client $client)
    {
        $user = $client->user;
        $transformer = '\Cortex\Auth\Transformers\\'.ucwords($client->user_type).'Transformer';

        return $this->item($user, new $transformer());
    }
}
