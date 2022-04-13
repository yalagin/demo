<?php

declare(strict_types=1);

namespace App\Security\Core;

use Lcobucci\JWT\Token;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

/**
 * Overrides UserProviderInterface to add $token optional parameter on loadUserByIdentifier method.
 * This is intended for HttpBearerAuthenticator.
 *
 * @author Vincent Chalamon <vincentchalamon@gmail.com>
 */
interface TokenAwareUserProviderInterface extends UserProviderInterface
{
    /**
     * {@inheritdoc}
     */
    public function loadUserByIdentifier(string $identifier, Token $token = null): UserInterface;
}
