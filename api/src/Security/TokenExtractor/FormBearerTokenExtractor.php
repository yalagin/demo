<?php

declare(strict_types=1);

namespace App\Security\TokenExtractor;

use Symfony\Component\HttpFoundation\Request;

/**
 * Implementation of the RFC 6750 for token extraction from Form-Encoded Body Parameter.
 *
 * @see https://datatracker.ietf.org/doc/html/rfc6750#section-2.2
 *
 * @author Vincent Chalamon <vincentchalamon@gmail.com>
 *
 * @final
 */
class FormBearerTokenExtractor implements BearerTokenExtractorInterface
{
    public function supports(Request $request): bool
    {
        return str_starts_with($request->headers->get('CONTENT_TYPE', ''), 'application/x-www-form-urlencoded')
            && !$request->isMethod(Request::METHOD_GET)
            && !empty($request->getContent()['access_token']);
    }

    public function extract(Request $request): string
    {
        return $request->getContent()['access_token'];
    }
}
