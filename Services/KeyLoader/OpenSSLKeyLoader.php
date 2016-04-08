<?php

namespace Lexik\Bundle\JWTAuthenticationBundle\Services\KeyLoader;

/**
 * Load OpenSSL config keys.
 *
 * @author Robin Chalas <robin.chalas@gmail.com>
 */
class OpenSSLKeyLoader extends AbstractKeyLoader
{
    /**
     * {@inheritdoc}
     *
     * @throws \RuntimeException If the key is not readable.
     * @throws \RuntimeException If the key cannot be loaded.
     */
    public function loadKey($type)
    {
        $path = $this->getKeyFromType($type);

        if (!file_exists($path) || !is_readable($path)) {
            throw new \RuntimeException($this->getUnreadableKeyMessage($type, $path));
        }

        $loadPath = 'file://' . $path;
        $key = call_user_func_array(
            sprintf('openssl_pkey_get_%s', $type),
            $type == 'private' ? [$loadPath, $this->passphrase] : [$loadPath]
        );
        
        if (!$key) {
            throw new \RuntimeException(sprintf(
                'Failed to load %s key "%s". Did you correctly configure the corresponding passphrase?',
                $type,
                $path
            ));
        }

        return $key;
    }
}
