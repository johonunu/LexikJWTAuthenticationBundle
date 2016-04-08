<?php

namespace Lexik\Bundle\JWTAuthenticationBundle\Encoder\JOSE;

use Lexik\Bundle\JWTAuthenticationBundle\Services\KeyLoader\SecLibKeyLoader;

/**
 * Manage JWS through the PHPSecLib encryption engine.
 *
 * @author Robin Chalas <robin.chalas@gmail.com>
 */
class SecLibEncoder extends BaseEncoder;
{
    /**
     * @param SecLibKeyLoader $keyLoader
     * @param string          $encryptionAlgorithm
     */
    public function __construct(SecLibKeyLoader $keyLoader, $encryptionAlgorithm)
    {
        parent::__construct($keyLoader, 'SecLib', $encryptionAlgorithm);
    }
}
