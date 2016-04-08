<?php

namespace Lexik\Bundle\JWTAuthenticationBundle\Services\KeyLoader;

/**
 * Load configuration keys.
 *
 * @author Robin Chalas <robin.chalas@gmail.com>
 */
abstract class AbstractKeyLoader implements KeyLoaderInterface
{
    /**
     * @var string
     */
    protected $privateKey;

    /**
     * @var string
     */
    protected $publicKey;

    /**
     * @var string
     */
    protected $passphrase;

    /**
     * Constructor.
     *
     * @param string $privateKey
     * @param string $publicKey
     * @param string $passphrase
     */
    public function __construct($privateKey, $publicKey, $passphrase)
    {
        $this->privateKey = $privateKey;
        $this->publicKey  = $publicKey;
        $this->passphrase = $passphrase;
    }

    /**
     * Checks that configured keys exists and private key can be parsed using the passphrase
     */
    public function checkConfig()
    {
        $this->loadKey('public');
        $this->loadKey('private');
    }

    /**
     * @param string $type The key type
     * @param string $path The key path
     *
     * @return string
     */
    protected function getUnreadableKeyMessage($type, $path)
    {
        return sprintf(
            '%s key "%s" does not exist or is not readable. Did you correctly set the "lexik_jwt_authentication.%s_key_path" parameter?',
            ucfirst($type),
            $path,
            $type
        );
    }

    /**
     * @param $type
     *
     * @throws \InvalidArgumentException If the given type is not valid.
     */
    protected function getKeyFromType($type)
    {
        $validTypes = ['public', 'private'];

        if (!in_array($type, $validTypes)) {
            throw new \InvalidArgumentException(
                sprintf('The "%s" key type is not valid (valid types: %s)', $type, implode(', ', $validTypes))
            );
        }

        $keyProperty = $type . 'Key';

        return $this->$keyProperty;
    }
}
