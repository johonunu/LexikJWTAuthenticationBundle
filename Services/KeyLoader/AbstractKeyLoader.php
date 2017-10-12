<?php

namespace Lexik\Bundle\JWTAuthenticationBundle\Services\KeyLoader;

/**
 * Abstract class for key loaders.
 *
 * @author Robin Chalas <robin.chalas@gmail.com>
 *
 * @internal since version 2.5
 */
abstract class AbstractKeyLoader implements KeyLoaderInterface
{
    /**
     * @var string
     */
    private $signingKey;

    /**
     * @var string|null
     */
    private $publicKey;

    /**
     * @var string|null
     */
    private $passphrase;

    /**
     * @param string      $signingKey
     * @param string|null $publicKey
     * @param string|null $passphrase
     */
    public function __construct($signingKey, $publicKey = null, $passphrase = null)
    {
        $this->signingKey = $signingKey;
        $this->publicKey  = $publicKey;
        $this->passphrase = $passphrase;
    }

    /**
     * {@inheritdoc}
     */
    public function getPassphrase()
    {
        return $this->passphrase;
    }

    /**
     * @return string The raw signing key
     */
    protected function getSigningKey()
    {
        return is_file($this->signingKey) ? $this->readKey(self::TYPE_PRIVATE) : $this->signingKey;
    }

    /**
     * @return string The raw public key
     */
    protected function getPublicKey()
    {
        return is_file($this->publicKey) ? $this->readKey(self::TYPE_PUBLIC) : $this->publicKey;
    }

    /**
     * @param string $type One of "public" or "private"
     *
     * @return string The path of the key, an empty string if not a valid path
     *
     * @throws \InvalidArgumentException If the given type is not valid
     */
    protected function getKeyPath($type)
    {
        if (!in_array($type, [self::TYPE_PUBLIC, self::TYPE_PRIVATE])) {
            throw new \InvalidArgumentException(sprintf('The key type must be "public" or "private", "%s" given.', $type));
        }

        $path = $this->signingKey;

        if (!is_file($path) || !is_readable($path)) {
            throw new \RuntimeException(
                sprintf('%s key "%s" does not exist or is not readable. Did you correctly set the "lexik_jwt_authentication.jwt_%s_key_path" config option?', ucfirst($type), $path, $type)
            );
        }

        return $path;
    }

    private function readKey($type)
    {
        $isPublic = self::TYPE_PUBLIC === $type;
        $key = $isPublic ? $this->publicKey : $this->signingKey;

        if (!$key || !is_file($key) || !is_readable($key)) {
            if ($isPublic) {
                return null;
            }

            throw new \RuntimeException(
                sprintf('Signature key "%s" does not exist or is not readable. Did you correctly set the "lexik_jwt_authentication.signature_key" configuration key?', $key, $type)
            );
        }
    }
}
