<?php

namespace Lexik\Bundle\JWTAuthenticationBundle\Encoder\JOSE;

use InvalidArgumentException;
use Lexik\Bundle\JWTAuthenticationBundle\Services\KeyLoader\KeyLoaderInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Encoder\JWTEncoderInterface;
use Namshi\JOSE\JWS;

/**
 * Base class managing JWS using Namshi/JOSE.
 *
 * @author Robin Chalas <robin.chalas@gmail.com>
 * @author Dev Lexik    <dev@lexik.fr>
 */
class BaseEncoder implements JWTEncoderInterface
{
    /**
     * @var KeyLoaderInterface
     */
    protected $keyLoader;

    /**
     * @var string
     */
    protected $encryptionAlgorithm;

    /**
     * @var string
     */
    protected $encryptionEngine;

    /**
     * Constructor.
     *
     * @param KeyLoaderInterface $keyLoader
     * @param string             $encryptionEngine
     * @param string             $encryptionAlgorithm
     *
     * @throws InvalidArgumentException If the given algorithm is not supported.
     */
    public function __construct(KeyLoaderInterface $keyLoader, $encryptionEngine, $encryptionAlgorithm)
    {
        if (!$this->isAlgorithmSupportedForEngine($encryptionEngine, $encryptionAlgorithm)) {
            throw new InvalidArgumentException(
                sprintf("The algorithm '%s' is not supported for %s", $encryptionAlgorithm, $encryptionEngine)
            );
        }

        $this->keyLoader           = $keyLoader;
        $this->encryptionEngine    = $encryptionEngine;
        $this->encryptionAlgorithm = $encryptionAlgorithm;
    }

    /**
     * {@inheritdoc}
     *
     * @throws InvalidArgumentException If the JWS cannot be signed
     */
    public function encode(array $data)
    {
        $jws = new JWS(['alg' => $this->encryptionAlgorithm], $this->encryptionEngine);
        $key = $this->keyLoader->loadKey('private');

        $jws->setPayload($data);

        try {
            $jws->sign($key);
        } catch (InvalidArgumentException $e) {
            throw new InvalidArgumentException(
                sprintf('An error occurred when verifying the JWS from the configured key/algorithm (%s). Please check your configuration according to the documentation.', $e->getMessage())
            );
        }

        return $jws->getTokenString();
    }

    /**
     * {@inheritdoc}
     *
     * @throws InvalidArgumentException If the JWS cannot be verified
     */
    public function decode($token)
    {
        try {
            $jws = JWS::load($token, false, null, $this->encryptionEngine);
        } catch (InvalidArgumentException $e) {
            return false;
        }

        $key     = $this->keyLoader->loadKey('public');
        $payload = $jws->getPayload();

        try {
            $isValid = $jws->verify($key, $this->encryptionAlgorithm) && !$this->isJWSExpired($payload);
        } catch (InvalidArgumentException $e) {
            throw new InvalidArgumentException(
                sprintf('An error occurred when verifying the JWS from the configured key/algorithm (%s). Please check your configuration according to the documentation.', $e->getMessage())
            );
        }

        if (false === $isValid) {
            return $isValid;
        }

        return $payload;
    }

    /**
     * @param string $encryptionEngine
     * @param string $encryptionAlgorithm
     *
     * @return boolean
     */
    public function isAlgorithmSupportedForEngine($encryptionEngine, $encryptionAlgorithm)
    {
        $signerClass = sprintf('Namshi\\JOSE\\Signer\\%s\\%s', $encryptionEngine, $encryptionAlgorithm);

        return class_exists($signerClass);
    }

    /**
     * Checks whether the token is expired based on the 'exp' value.
     *
     * @param array $payload
     *
     * @return bool
     */
    public function isJWSExpired(array $payload)
    {
        if (isset($payload['exp']) && is_numeric($payload['exp'])) {
            $now = new \DateTime('now');

            return ($now->format('U') - $payload['exp']) > 0;
        }

        return false;
    }
}
