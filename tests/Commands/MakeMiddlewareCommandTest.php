<?php

namespace Rougin\Weasley\Commands;

use Symfony\Component\Console\Tester\CommandTester;

class MakeMiddlewareCommandTest extends \Rougin\Weasley\Testcase
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
    protected function doSetUp()
    {
        $this->console = new \Rougin\Weasley\Console;
    }

    /**
     * Tests MakeMiddlewareCommand::execute.
     *
     * @return void
     */
    public function testExecuteMethod()
    {
        $command = new CommandTester($this->console->find('make:middleware'));

        $command->execute(array('name' => 'TestMiddleware'));

        $expected = __DIR__ . '/../../src/Http/Middleware/TestMiddleware.php';

        $original = __DIR__ . '/../Fixture/Templates/TestMiddleware.php';

        $this->assertFileEquals($expected, $original);

        unlink($expected);
    }
}
