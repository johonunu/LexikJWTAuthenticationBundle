<?php

namespace Lexik\Bundle\JWTAuthenticationBundle\Encoder\JOSE;

use Lexik\Bundle\JWTAuthenticationBundle\Services\KeyLoader\OpenSSLKeyLoader;

/**
 * Manage JWS through the OpenSSL encryption engine.
 *
 * @author Robin Chalas <robin.chalas@gmail.com>
 */
class OpenSSLEncoder extends BaseEncoder
{
    /**
     * @param OpenSSLKeyLoader $keyLoader
     * @param string           $encryptionAlgorithm
     */
    public function __construct(OpenSSLKeyLoader $keyLoader, $encryptionAlgorithm)
    {
        parent::__construct($keyLoader, 'OpenSSL', $encryptionAlgorithm);
    }
}
