<?php

namespace Lexik\Bundle\JWTAuthenticationBundle\Services\KeyGenerator;

/**
 * Contract for SSH Key Generators.
 */
interface KeyGeneratorInterface
{
    /**
     * Generate a public/private key pair.
     *
     * @return array An array containing the key pair ready to export.
     */
    public function generate();

    /**
     * Export a public/private key pair previously generated.
     *
     * @param array $keys
     */
    public function export(array $keys);
}
