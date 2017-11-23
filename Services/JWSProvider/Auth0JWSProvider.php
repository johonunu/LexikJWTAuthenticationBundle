<?php

namespace Lexik\Bundle\JWTAuthenticationBundle\Services\JWSProvider;

use Auth0\SDK\JWTVerifier;
use Auth0\SDK\API\Management;
use Auth0\SDK\API\Authentication;
use Auth0\SDK\API\Helpers\TokenGenerator;
use Lexik\Bundle\JWTAuthenticationBundle\Services\KeyLoader\RawKeyLoader;
use Lexik\Bundle\JWTAuthenticationBundle\Signature\CreatedJWS;
use Lexik\Bundle\JWTAuthenticationBundle\Signature\LoadedJWS;

/**
 * @internal
 *
 * @author Robin Chalas <robin.chalas@gmail.com>
 */
class Auth0JWSProvider implements JWSProviderInterface
{
    /**
     * @var RawKeyLoader
     */
    private $keyLoader;

    /**
     * @var JWTVerifier
     */
    private $verifier;

    /**
     * @var TokenGenerator
     */
    private $generator;

    /**
     * @param RawKeyLoader $keyLoader
     * @param string       $cryptoEngine
     * @param string       $signatureAlgorithm
     * @param int|null     $ttl
     *
     * @throws \InvalidArgumentException If the given crypto engine is not supported
     */
    public function __construct(RawKeyLoader $keyLoader, $cryptoEngine, $signatureAlgorithm, $ttl)
    {
        if (null !== $ttl && !is_numeric($ttl)) {
            throw new \InvalidArgumentException(sprintf('The TTL should be a numeric value, got %s instead.', $ttl));
        }

        $this->keyLoader = $keyLoader;
        $this->signer    = $this->getSignerForAlgorithm($signatureAlgorithm);
        $this->ttl       = $ttl;
    }

    /**
     * {@inheritdoc}
     */
    public function create(array $payload, array $header = [])
    {
        // Generate via Auth0 api
    }

    /**
     * {@inheritdoc}
     */
    public function load($token)
    {
        $verifier = new JWTVerifier():
    }
}
