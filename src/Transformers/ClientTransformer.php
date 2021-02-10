<?php

declare(strict_types=1);

namespace Cortex\OAuth\Transformers;

use Illuminate\Support\Str;
use Cortex\OAuth\Models\Client;
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
    protected $defaultIncludes = [
        'user',
    ];

    /**
     * Transform client model.
     *
     * @param \Cortex\OAuth\Models\Client $client
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
            'provider' => (string) $client->provider,
            'grant_type' => (string) $client->grant_type,
            'is_revoked' => (bool) $client->is_revoked,
            'created_at' => (string) $client->created_at,
            'updated_at' => (string) $client->updated_at,
        ]);
    }

    /**
     * Include Author.
     *
     * @param \Cortex\OAuth\Models\Client $client
     *
     * @return \League\Fractal\Resource\Item
     */
    public function includeUser(Client $client)
    {
        $user = $client->user;
        $transformer = '\Cortex\Auth\Transformers\\'.ucwords(Str::singular($client->provider)).'Transformer';

        return $this->item($user, new $transformer());
    }
}
