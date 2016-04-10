<?php

namespace Lexik\Bundle\JWTAuthenticationBundle\Command;

use Lexik\Bundle\JWTAuthenticationBundle\Encoder\JOSE\OpenSSLEncoder;
use Lexik\Bundle\JWTAuthenticationBundle\Encoder\JOSE\SecLibEncoder;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;
use Symfony\Component\Yaml\Dumper;

/**
 * GenerateSSHKeysCommand.
 *
 * @author Robin Chalas <robin.chalas@gmail.com>
 */
class GenerateSSHKeysCommand extends ContainerAwareCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
          ->setName('lexik:jwt:generate-ssh-keys')
          ->setDescription('Generate SSH keys for JWS encoding/decoding');
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $encoder   = $this->getContainer()->get('lexik_jwt_authentication.jwt_encoder');
        $engine    = $encoder->getEncryptionEngine();
        $algorithm = $encoder->getEncryptionAlgorithm();

        if ($engine == 'OpenSSL') {
            if (strpos($algorithm, 'RS')) {
                $keyGenerator = $this->getContainer()->get('lexik_jwt_authentication.key_generator.open_ssl.rsa')
            } // TODO: Handle EDCSA + HMAC
        } elseif ($engine == 'SecLib') {
            if (strpos($algorithm, 'RS')) {
                $keyGenerator = $this->getContainer()->get('lexik_jwt_authentication.key_generator.sec_lib.rsa');
            }
        }

        $keys = $keyGenerator->generate();

        try {
            $keyGenerator->export($keys);
        } catch (\RuntimeException $e) {
            $output->writeln('<error>' . $e->getMessage() . '</error>');

            return 1;
        }

        $output->writeln(sprintf('<info>RSA keys successfully generated</info>', $successMsg));

        return 0;
    }
}
