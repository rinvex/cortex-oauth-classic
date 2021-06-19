<?php

declare(strict_types=1);

namespace Cortex\Oauth\Http\Controllers\Apiarea;

use Cortex\Foundation\Http\Controllers\AuthorizedController;
use Cortex\Tags\Models\Tag;

class ChallengesController extends AuthorizedController
{
    /**
     * {@inheritdoc}
     */
    protected $resource = 'rinvex.tags.models.tag';

    public function index()
    {
        dd('Hello world!');
    }
}
