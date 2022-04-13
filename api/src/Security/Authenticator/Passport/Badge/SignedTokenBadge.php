<?php

declare(strict_types=1);

namespace App\Security\Authenticator\Passport\Badge;

use Lcobucci\JWT\Configuration;
use Lcobucci\JWT\Token;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\BadgeInterface;

/**
 * @author Vincent Chalamon <vincentchalamon@gmail.com>
 *
 * @final
 */
class SignedTokenBadge implements BadgeInterface
{
    private Configuration $configuration;
    private Token $payload;

    public function __construct(Configuration $configuration, Token $token)
    {
        $this->configuration = $configuration;
        $this->payload = $token;
    }

    public function getConfiguration(): Configuration
    {
        return $this->configuration;
    }

    public function getToken(): Token
    {
        return $this->payload;
    }

    public function isResolved(): bool
    {
        return true;
    }
}
