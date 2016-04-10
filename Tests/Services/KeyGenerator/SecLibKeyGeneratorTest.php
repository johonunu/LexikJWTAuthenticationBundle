<?php

namespace Lexik\Bundle\JWTAuthenticationBundle\Tests\Services\KeyGenerator\SecLib;

use Lexik\Bundle\JWTAuthenticationBundle\Tests\Services\KeyGenerator\BaseTestKeyGenerator;
use Lexik\Bundle\JWTAuthenticationBundle\Services\KeyGenerator\SecLibKeyGenerator;

/**
 * OpenSSLKeyLoaderTest
 *
 * @author Robin Chalas <robin.chalas@gmail.com>
 */
class SecLibKeyGeneratorTest extends BaseTestKeyGenerator
{
    /**
     * {@inheritdoc}
     */
    public function setUp()
    {
        $this->keyGenerator = new SecLibKeyGenerator('private.pem', 'public.pem', 'foobar');
    }
}
