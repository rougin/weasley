<?php

namespace Rougin\Weasley\Commands;

use Symfony\Component\Console\Tester\CommandTester;

class MakeIntegrationCommandTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Rougin\Weasley\Console
     */
    protected $console;

    /**
     * Sets up the console application.
     *
     * @return void
     */
    public function setUp()
    {
        $this->console = new \Rougin\Weasley\Console;
    }

    /**
     * Tests MakeIntegrationCommand::execute.
     *
     * @return void
     */
    public function testExecuteMethod()
    {
        $command = new CommandTester($this->console->find('make:integration'));

        $command->execute(array('name' => 'TestIntegration'));

        $expected = __DIR__ . '/../../src/Integrations/TestIntegration.php';

        $original = __DIR__ . '/../Fixture/Templates/TestIntegration.php';

        $this->assertFileEquals($expected, $original);

        unlink($expected);
    }
}
