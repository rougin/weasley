<?php

namespace Rougin\Weasley\Commands;

use Rougin\Weasley\Console;
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
     * @var \Symfony\Component\Console\Application
     */
    protected $app;

    /**
     * @var string
     */
    protected $name = 'make:controller';

    /**
     * @return void
     */
    public function test_passed_if_created()
    {
        $command = $this->app->find($this->name);

        $command = new CommandTester($command);

        $data = array('name' => 'TestController');

        $command->execute($data);

        $path = '/src/Http/Controllers';
        $path .= '/TestController.php';

        $file = $this->getRoot() . $path;

        /** @var string */
        $expect = file_get_contents($file);

        $expect = str_replace("\r\n", "\n", $expect);

        $path = '/tests/Fixture/Templates';
        $path .= '/TestController.php';

        $actual = $this->getRoot() . $path;

        /** @var string */
        $actual = file_get_contents($actual);

        $actual = str_replace("\r\n", "\n", $actual);

        $this->assertEquals($expect, $actual);

        unlink($file);
    }

    /**
     * @return void
     */
    protected function doSetUp()
    {
        $app = new Console;

        $this->app = $app->make();
    }
}
