<?php

declare(strict_types=1);

namespace Cortex\Oauth\Transformers;

use Rinvex\Support\Traits\Escaper;
use Cortex\Oauth\Models\AccessToken;
use League\Fractal\TransformerAbstract;

class AccessTokenTransformer extends TransformerAbstract
{
    use Escaper;

    /**
     * List of resources to automatically include.
     *
     * @var array
     */
    protected $defaultIncludes = [
        'client',
        'user',
    ];

    /**
     * Transform auth code model.
     *
     * @param \Cortex\Oauth\Models\AccessToken $accessToken
     *
     * @throws \Exception
     *
     * @return array
     */
    public function transform(AccessToken $accessToken): array
    {
        return $this->escape([
            'id' => (string) $accessToken->getRouteKey(),
            'name' => (string) $accessToken->name,
            'user_type' => (string) $accessToken->user_type,
            'abilities' => (string) $accessToken->abilities->isNotEmpty() ? $accessToken->abilities->map->title->all() : [],
            'is_revoked' => (bool) $accessToken->is_revoked,
            'expires_at' => (string) $accessToken->expires_at,
            'created_at' => (string) $accessToken->created_at,
            'updated_at' => (string) $accessToken->updated_at,
        ]);
    }

    /**
     * Include Author.
     *
     * @param \Cortex\Oauth\Models\AccessToken $accessToken
     *
     * @return \League\Fractal\Resource\Item
     */
    public function includeClient(AccessToken $accessToken)
    {
        $client = $accessToken->client;

        return $this->item($client, new ClientTransformer());
    }

    /**
     * Include Author.
     *
     * @param \Cortex\Oauth\Models\AccessToken $accessToken
     *
     * @return \League\Fractal\Resource\Item
     */
    public function includeUser(AccessToken $accessToken)
    {
        $user = $accessToken->user;
        $transformer = '\Cortex\Auth\Transformers\\'.ucwords($accessToken->user_type).'Transformer';

        return $this->item($user, new $transformer());
    }
}
