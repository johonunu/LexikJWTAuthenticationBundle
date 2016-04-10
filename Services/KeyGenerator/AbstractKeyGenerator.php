<?php

namespace Lexik\Bundle\JWTAuthenticationBundle\Services\KeyGenerator;

/**
 * AbstractKeyGenerator.
 *
 * @author Robin Chalas <robin.chalas@gmail.com>
 */
abstract class AbstractKeyGenerator implements KeyGeneratorInterface
{
    /**
     * @var string
     */
    protected $publicKeyPath;

    /**
     * @var string
     */
    protected $privateKeyPath;

    /**
     * @var string
     */
    protected $passphrase;

    /**
     * Constructor.
     *
     * @param string $privateKeyPath
     * @param string $publicKeyPath
     * @param string $passphrase
     */
    public function __construct($privateKeyPath, $publicKeyPath, $passphrase)
    {
        $this->privateKeyPath = $privateKeyPath;
        $this->publicKeyPath  = $publicKeyPath;
        $this->passphrase = $passphrase;
    }
}
