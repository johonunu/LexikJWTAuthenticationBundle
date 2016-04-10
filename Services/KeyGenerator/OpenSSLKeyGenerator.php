<?php

namespace Lexik\Bundle\JWTAuthenticationBundle\Services\KeyGenerator;

/**
 * Generate SSH keys for OpenSSL.
 *
 * @author Robin Chalas <robin.chalas@gmail.com>
 */
class OpenSSLKeyGenerator extends AbstractKeyGenerator
{
    /**
     * {@inheritdoc}
     */
    public function generate()
    {
        $privateKey = openssl_pkey_new(array(
            'private_key_bits'   => 4096,
            'private_key_type' 	 => OPENSSL_KEYTYPE_RSA,
            'encrypt_key'				 => true,
            'encrypt_key_cipher' => OPENSSL_CIPHER_AES_256_CBC,
        ));

        $detail = openssl_pkey_get_details($privateKey);

        return [
            'private' => $privateKey,
            'public'  => $detail['key'],
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
            openssl_pkey_export_to_file($keys['private'], $this->privateKeyPath, $this->passphrase);
            file_put_contents($this->publicKeyPath, $keys['public']);
        } catch (\Exception $e) {
            throw new \RuntimeException($e->getMessage());
        }
    }
}
