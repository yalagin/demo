<?php

declare(strict_types=1);

namespace App\Security\Authenticator\EventListener;

use App\Security\Authenticator\Passport\Badge\SignedTokenBadge;
use Lcobucci\JWT\Validation\Constraint\SignedWith;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;
use Symfony\Component\Security\Http\Event\CheckPassportEvent;

/**
 * Validate Token signature from Bearer authentication.
 *
 * @author Vincent Chalamon <vincentchalamon@gmail.com>
 *
 * @final
 */
class ValidateSignedTokenListener implements EventSubscriberInterface
{
    public static function getSubscribedEvents(): array
    {
        return [CheckPassportEvent::class => 'checkPassport'];
    }

    public function checkPassport(CheckPassportEvent $event): void
    {
        $passport = $event->getPassport();
        if (!$passport->hasBadge(SignedTokenBadge::class)) {
            return;
        }

        /** @var SignedTokenBadge $badge */
        $badge = $passport->getBadge(SignedTokenBadge::class);
        $configuration = $badge->getConfiguration();

        $configuration->setValidationConstraints(new SignedWith($configuration->signer(), $configuration->signingKey()));

        if (!$configuration->validator()->validate($badge->getToken(), ...$configuration->validationConstraints())) {
            throw new BadCredentialsException('The token signature is invalid.');
        }
    }
}
