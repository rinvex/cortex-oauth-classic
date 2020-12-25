<?php

declare(strict_types=1);

namespace Cortex\OAuth\Traits;

use Illuminate\Http\Response;

trait ConvertsPsrResponses
{
    /**
     * Convert a PSR7 response to a Illuminate Response.
     *
     * @param \Psr\Http\Message\ResponseInterface $psrResponse
     *
     * @return \Illuminate\Http\Response
     */
    public function convertResponse($psrResponse)
    {
        return new Response(
            $psrResponse->getBody(),
            $psrResponse->getStatusCode(),
            $psrResponse->getHeaders()
        );
    }
}
