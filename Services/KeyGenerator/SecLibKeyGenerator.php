<?php

namespace Lexik\Bundle\JWTAuthenticationBundle\Services\KeyGenerator;

use phpseclib\Crypt\RSA;

/**
 * Generate SSH keys for SecLib.
 *
 * @author Robin Chalas <robin.chalas@gmail.com>
 */
class SecLibKeyGenerator extends AbstractKeyGenerator
{
    /**
     * {@inheritdoc}
     */
    public function generate()
    {
        $rsa = new RSA();
        $rsa->setPassword($this->passphrase);

        extract($rsa->createKey(4096));

        return [
            'private' => $privatekey,
            'public'  => $publickey,
        ];
    }

    /**
     * {@inheritdoc}
     *
     * @throws \RuntimeException If an error occurs
     */
    public function export(array $keys)
    {
        try {
            file_put_contents($this->publicKeyPath, $keys['public']);
            file_put_contents($this->privateKeyPath, $keys['private']);
        } catch (\Exception $e) {
            throw new \RuntimeException($e->getMessage());
        }
    }
}
