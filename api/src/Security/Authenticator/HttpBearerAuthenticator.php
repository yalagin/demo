<?php

declare(strict_types=1);

namespace App\Security\Authenticator;

use App\Security\Authenticator\Passport\Badge\SignedTokenBadge;
use App\Security\Authenticator\Passport\Badge\TokenBadge;
use Lcobucci\JWT\Configuration;
use Lcobucci\JWT\Token;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;

/**
 * @author Vincent Chalamon <vincentchalamon@gmail.com>
 *
 * @final
 */
class HttpBearerAuthenticator extends AbstractBearerAuthenticator
{
    private Configuration $configuration;

    public function __construct(UserProviderInterface $userProvider, Configuration $configuration, string $realmName, string $payloadKey, LoggerInterface $logger = null)
    {
        parent::__construct($userProvider, $realmName, $payloadKey, $logger);

        $this->configuration = $configuration;
    }

    /**
     * Override Passport to add SignedTokenBadge.
     */
    public function authenticate(Request $request): Passport
    {
        $passport = parent::authenticate($request);

        return $passport->addBadge(new SignedTokenBadge($this->configuration, $passport->getBadge(TokenBadge::class)->getToken()));
    }

    protected function getToken(string $data): Token
    {
        return $this->configuration->parser()->parse($data);
    }
}
