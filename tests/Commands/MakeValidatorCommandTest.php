<?php

namespace Rougin\Weasley\Commands;

use Symfony\Component\Console\Tester\CommandTester;

class MakeValidatorCommandTest extends \Rougin\Weasley\Testcase
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
     * Tests MakeValidatorCommand::execute.
     *
     * @return void
     */
    public function testExecuteMethod()
    {
        $command = new CommandTester($this->console->find('make:validator'));

        $command->execute(array('name' => 'TestValidator'));

        $expected = __DIR__ . '/../../src/Validators/TestValidator.php';
        $filename = $expected;
        /** @var string */
        $expected = file_get_contents($expected);
        $expected = str_replace("\r\n", "\n", $expected);

        $original = __DIR__ . '/../Fixture/Templates/TestValidator.php';
        /** @var string */
        $original = file_get_contents($original);

        $this->assertEquals($expected, $original);

        unlink($filename);
    }
}
