<?php

namespace Lexik\Bundle\JWTAuthenticationBundle\Tests\Functional\Command;

use Lexik\Bundle\JWTAuthenticationBundle\Tests\Functional\TestCase;
use Symfony\Component\Console\Tester\CommandTester;

/**
 * CheckOpenSSLCommandTest.
 *
 * @author Nicolas Cabot <n.cabot@lexik.fr>
 */
class CheckConfigCommandTest extends TestCase
{
    /**
     * Test command.
     */
    public function testCheckOpenSSLCommand()
    {
        $kernel = $this->bootKernel();

        $tester = new CommandTester($kernel->getContainer()->get('lexik_jwt_authentication.check_config_command'));

        $tester->execute([]);
        $this->assertEquals(0, $tester->execute([]));


        $this->assertContains('The configuration seems correct.', $tester->getDisplay());
    }
}
