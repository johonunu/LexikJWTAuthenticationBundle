<?php

namespace Lexik\Bundle\JWTAuthenticationBundle\Tests\Services\KeyGenerator;

use Lexik\Bundle\JWTAuthenticationBundle\Services\KeyGenerator\OpenSSLKeyGenerator;

/**
 * OpenSSLKeyLoaderTest
 *
 * @author Robin Chalas <robin.chalas@gmail.com>
 */
class OpenSSLKeyGeneratorTest extends BaseTestKeyGenerator
{
    /**
     * {@inheritdoc}
     */
    public function setUp()
    {
        $this->keyGenerator = new OpenSSLKeyGenerator('private.pem', 'public.pem', 'foobar');
    }
}
