<?php

declare(strict_types=1);

namespace App\Security\TokenExtractor;

use Symfony\Component\HttpFoundation\Request;

/**
 * @author Vincent Chalamon <vincentchalamon@gmail.com>
 */
interface BearerTokenExtractorInterface
{
    public function supports(Request $request): bool;

    public function extract(Request $request): string;
}
