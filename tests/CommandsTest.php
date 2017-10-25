<?php

namespace Rougin\Weasley;

use Symfony\Component\Console\Tester\CommandTester;

class CommandsTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Rougin\Weasley\Console\Application
     */
    protected $console;

    /**
     * Sets up the console application.
     *
     * @return void
     */
    public function setUp()
    {
        $this->console = new \Rougin\Weasley\Console\Application;
    }

    /**
     * Tests MakeControllerCommand.
     *
     * @return void
     */
    public function testControllerCommand()
    {
        $command = new CommandTester($this->console->find('make:controller'));

        $command->execute(array('name' => 'TestController'));

        $expected = __DIR__ . '/../src/Http/Controllers/TestController.php';

        $original = __DIR__ . '/Fixture/Templates/TestController.php';

        $this->assertFileEquals($expected, $original);

        unlink($expected);
    }

    /**
     * Tests MakeIntegrationCommand.
     *
     * @return void
     */
    public function testIntegrationCommand()
    {
        $command = new CommandTester($this->console->find('make:integration'));

        $command->execute(array('name' => 'TestIntegration'));

        $expected = __DIR__ . '/../src/Integrations/TestIntegration.php';

        $original = __DIR__ . '/Fixture/Templates/TestIntegration.php';

        $this->assertFileEquals($expected, $original);

        unlink($expected);
    }

    /**
     * Tests MakeMiddlewareCommand.
     *
     * @return void
     */
    public function testMiddlewareCommand()
    {
        $command = new CommandTester($this->console->find('make:middleware'));

        $command->execute(array('name' => 'TestMiddleware'));

        $expected = __DIR__ . '/../src/Http/Middleware/TestMiddleware.php';

        $original = __DIR__ . '/Fixture/Templates/TestMiddleware.php';

        $this->assertFileEquals($expected, $original);

        unlink($expected);
    }

    /**
     * Tests MakeValidatorCommand.
     *
     * @return void
     */
    public function testValidatorCommand()
    {
        $command = new CommandTester($this->console->find('make:validator'));

        $command->execute(array('name' => 'TestValidator'));

        $expected = __DIR__ . '/../src/Validators/TestValidator.php';

        $original = __DIR__ . '/Fixture/Templates/TestValidator.php';

        $this->assertFileEquals($expected, $original);

        unlink($expected);
    }
}
