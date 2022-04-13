<?php

declare(strict_types=1);

namespace App\Security\Authenticator;

use Lcobucci\JWT\Token;
use Lcobucci\JWT\Token\Signature;

/**
 * Example of alternative HttpBearerAuthenticator (e.g.: in tests to mock Token).
 *
 * @author Vincent Chalamon <vincentchalamon@gmail.com>
 *
 * @final
 */
class MockHttpBearerAuthenticator extends AbstractBearerAuthenticator
{
    protected function getToken(string $data): Token
    {
        return new Token\Plain(
            new Token\DataSet([], ''),
            new Token\DataSet(['email' => $data], ''),
            new Signature('', '')
        );
    }
}
