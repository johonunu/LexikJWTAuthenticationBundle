<?php

namespace Lexik\Bundle\JWTAuthenticationBundle\Encoder;

use Lexik\Bundle\JWTAuthenticationBundle\Services\JWSProvider\Auth0JWSProvider;

/**
 * Json Web Token encoder/decoder based on the auth0/auth0-php library.
 *
 * @author Robin Chalas <robin.chalas@gmail.com>
 */
class Auth0Encoder extends DefaultEncoder
{
    public function __construct(Auth0JWSProvider $jwsProvider)
    {
        parent::__construct($jwsProvider);
    }
}
