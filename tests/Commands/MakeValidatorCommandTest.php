<?php

namespace Rougin\Weasley\Commands;

use Rougin\Weasley\Testcase;
use Symfony\Component\Console\Tester\CommandTester;

/**
 * @package Weasley
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class MakeValidatorCommandTest extends Testcase
{
    /**
     * @var \Rougin\Weasley\Console
     */
    protected $console;

    /**
     * @return void
     */
    protected function doSetUp()
    {
        $this->console = new \Rougin\Weasley\Console;
    }

    /**
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
        $original = str_replace("\r\n", "\n", $original);

        $this->assertEquals($expected, $original);

        unlink($filename);
    }

    /**
     * @return void
     */
    public function test_make_check_command()
    {
        $command = new CommandTester($this->console->find('make:check'));

        $command->execute(array('name' => 'TestCheck'));

        $expected = __DIR__ . '/../../src/Checks/TestCheck.php';
        $filename = $expected;
        /** @var string */
        $expected = file_get_contents($expected);
        $expected = str_replace("\r\n", "\n", $expected);

        $original = __DIR__ . '/../Fixture/Templates/TestCheck.php';
        /** @var string */
        $original = file_get_contents($original);
        $original = str_replace("\r\n", "\n", $original);

        $this->assertEquals($expected, $original);

        unlink($filename);
    }
}
