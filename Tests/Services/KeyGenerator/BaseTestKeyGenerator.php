<?php

namespace Lexik\Bundle\JWTAuthenticationBundle\Tests\Services\KeyGenerator;

use Lexik\Bundle\JWTAuthenticationBundle\Services\KeyGenerator\KeyGeneratorInterface;

/**
 * OpenSSLKeyLoaderTest
 *
 * @author Robin Chalas <robin.chalas@gmail.com>
 */
class BaseTestKeyGenerator extends \PHPUnit_Framework_TestCase
{
    /**
     * @var KeyGeneratorInterface
     */
    protected $keyGenerator;

    /**
     * Test OpenSSLKeyGeneator::generate().
     */
    public function testGenerate()
    {
        $keys = $this->keyGenerator->generate();

        $this->assertTrue(is_array($keys));
        $this->assertArrayHasKey('public', $keys);
        $this->assertArrayHasKey('private', $keys);
    }

    /**
     * Test OpenSSLKeyGeneator::export().
     */
    public function testExport()
    {
        $keys = $this->keyGenerator->generate();
        $this->keyGenerator->export($keys);

        $this->assertFileExists('private.pem');
        $this->assertFileExists('public.pem');
    }

    /**
     * {@inheritdoc}
     */
    public function tearDown()
    {
        $privateKey = 'private.pem';
        $publicKey  = 'public.pem';

        if (file_exists($publicKey)) {
            unlink($publicKey);
        }

        if (file_exists($privateKey)) {
            unlink($privateKey);
        }
    }
}
