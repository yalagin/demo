<?php

declare(strict_types=1);

namespace App\Security\Authenticator\Passport;

use App\Security\Authenticator\Passport\Badge\TokenBadge;
use LogicException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Http\Authenticator\Passport\SelfValidatingPassport;

/**
 * @author Vincent Chalamon <vincentchalamon@gmail.com>
 *
 * @final
 */
class TokenPassport extends SelfValidatingPassport
{
    public function __construct(TokenBadge $tokenBadge, array $badges = [])
    {
        parent::__construct($tokenBadge, $badges);
    }

    public function getUser(): UserInterface
    {
        if (null === $this->user) {
            if (!$this->hasBadge(TokenBadge::class)) {
                throw new LogicException('Cannot get the Security user, no username or TokenBadge configured for this passport.');
            }

            /* @phpstan-ignore-next-line */
            $this->user = $this->getBadge(TokenBadge::class)->getUser();
        }

        return $this->user;
    }
}
