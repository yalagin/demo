<?php

declare(strict_types=1);

namespace App\Security\Authenticator;

use Lcobucci\JWT\Token;
use Lcobucci\JWT\Token\DataSet;
use Lcobucci\JWT\Token\Plain;
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
        return new Plain(
            new DataSet([], ''),
            new DataSet(['email' => $data], ''),
            new Signature('', '')
        );
    }
}
