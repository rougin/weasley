<?php

namespace Rougin\Weasley\Commands;

use Rougin\Weasley\Testcase;
use Symfony\Component\Console\Tester\CommandTester;

/**
 * @package Weasley
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class MakeControllerCommandTest extends Testcase
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
        $command = new CommandTester($this->console->find('make:controller'));

        $command->execute(array('name' => 'TestController'));

        $expected = __DIR__ . '/../../src/Http/Controllers/TestController.php';
        $filename = $expected;
        /** @var string */
        $expected = file_get_contents($expected);
        $expected = str_replace("\r\n", "\n", $expected);

        $original = __DIR__ . '/../Fixture/Templates/TestController.php';
        /** @var string */
        $original = file_get_contents($original);
        $original = str_replace("\r\n", "\n", $original);

        $this->assertEquals($expected, $original);

        unlink($filename);
    }
}
