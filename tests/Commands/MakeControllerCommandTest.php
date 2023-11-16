<?php

namespace Rougin\Weasley\Commands;

use Symfony\Component\Console\Tester\CommandTester;

class MakeControllerCommandTest extends \Rougin\Weasley\Testcase
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
     * Tests MakeControllerCommand::execute.
     *
     * @return void
     */
    public function testExecuteMethod()
    {
        $command = new CommandTester($this->console->find('make:controller'));

        $command->execute(array('name' => 'TestController'));

        $expected = __DIR__ . '/../../src/Http/Controllers/TestController.php';

        $original = __DIR__ . '/../Fixture/Templates/TestController.php';

        $this->assertFileEquals($expected, $original);

        unlink($expected);
    }
}
