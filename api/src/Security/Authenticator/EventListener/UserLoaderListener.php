<?php

declare(strict_types=1);

namespace App\Security\Authenticator\EventListener;

use App\Security\Authenticator\Passport\Badge\TokenBadge;
use App\Security\Core\TokenAwareUserProviderInterface;
use Lcobucci\JWT\Token;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Http\Event\CheckPassportEvent;

/**
 * @author Vincent Chalamon <vincentchalamon@gmail.com>
 *
 * @final
 */
class UserLoaderListener implements EventSubscriberInterface
{
    private UserProviderInterface $userProvider;

    public function __construct(UserProviderInterface $userProvider)
    {
        $this->userProvider = $userProvider;
    }

    public static function getSubscribedEvents(): array
    {
        return [CheckPassportEvent::class => ['checkPassport', 2048]];
    }

    public function checkPassport(CheckPassportEvent $event): void
    {
        $passport = $event->getPassport();
        if (!$passport->hasBadge(TokenBadge::class)) {
            return;
        }

        /** @var TokenBadge $badge */
        $badge = $passport->getBadge(TokenBadge::class);
        if (null !== $badge->getUserLoader()) {
            return;
        }

        if (!$this->userProvider instanceof TokenAwareUserProviderInterface) {
            return;
        }

        $badge->setUserLoader(function (string $identifier, ?Token $token): UserInterface {
            /* @phpstan-ignore-next-line */
            return $this->userProvider->loadUserByIdentifier($identifier, $token);
        });
    }
}
