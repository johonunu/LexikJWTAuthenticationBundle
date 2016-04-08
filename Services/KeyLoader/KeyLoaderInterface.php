<?php

namespace Lexik\Bundle\JWTAuthenticationBundle\Services\KeyLoader;

/**
 * KeyLoaderInterface.
 *
 * @author Robin Chalas <robin.chalas@gmail.com>
 */
interface KeyLoaderInterface
{
    /**
     * Load a key from a given type (public or private).
     *
     * @param string Either
     *
     * @return string
     */
    public function loadKey($type);
}
