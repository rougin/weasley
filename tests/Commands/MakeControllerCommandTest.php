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
        // Run the command from the console app ---
        $command = $this->app->find($this->name);

        $command = new CommandTester($command);

        $data = array('name' => 'TestController');

        $command->execute($data);
        // ----------------------------------------

        // Prepare the expected file after generation -----
        $path = '/src/Http/Controllers/TestController.php';

        $expect = $file = $this->getRoot() . $path;

        /** @var string */
        $expect = file_get_contents($expect);

        $expect = str_replace("\r\n", "\n", $expect);
        // ------------------------------------------------

        // Find the actual generated file --------------------
        $path = '/tests/Fixture/Templates/TestController.php';

        $actual = $this->getRoot() . $path;

        /** @var string */
        $actual = file_get_contents($actual);

        $actual = str_replace("\r\n", "\n", $actual);
        // ---------------------------------------------------

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
