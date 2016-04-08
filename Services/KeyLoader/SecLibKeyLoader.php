<?php

namespace Lexik\Bundle\JWTAuthenticationBundle\Services\KeyLoader;

/**
 * Load PHPSecLib config keys.
 *
 * @author Robin Chalas <robin.chalas@gmail.com>
 */
class SecLibKeyLoader extends AbstractKeyLoader
{
    /**
     * {@inheritdoc}
     *
     * @throws \RuntimeException If the key is not readable.
     */
    public function loadKey($type)
    {
        $path = $this->getKeyFromType($type);

        if (!file_exists($path) || !is_readable($path)) {
            throw new \RuntimeException($this->getUnreadableKeyMessage($type, $path));
        }

        return file_get_contents($path);
    }
}
