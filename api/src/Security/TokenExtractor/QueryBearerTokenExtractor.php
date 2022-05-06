<?php

declare(strict_types=1);

namespace App\Security\TokenExtractor;

use Symfony\Component\HttpFoundation\Request;

/**
 * Implementation of the RFC 6750 for token extraction from Form-Encoded Body Parameter.
 *
 * @see https://datatracker.ietf.org/doc/html/rfc6750#section-2.3
 *
 * @author Vincent Chalamon <vincentchalamon@gmail.com>
 *
 * @final
 */
class QueryBearerTokenExtractor implements BearerTokenExtractorInterface
{
    public function supports(Request $request): bool
    {
        return $request->query->has('access_token');
    }

    public function extract(Request $request): string
    {
        return $request->query->get('access_token');
    }
}
