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
class MakeValidatorCommandTest extends Testcase
{
    /**
     * @var \Symfony\Component\Console\Application
     */
    protected $app;

    /**
     * @var string
     */
    protected $name = 'make:validator';

    /**
     * @return void
     */
    public function test_passed_if_created()
    {
        // Run the command from the console app ---
        $command = $this->app->find($this->name);

        $command = new CommandTester($command);

        $data = array('name' => 'TestValidator');

        $command->execute($data);
        // ----------------------------------------

        // Prepare the expected file after generation ---
        $path = '/src/Validators/TestValidator.php';

        $expect = $file = $this->getRoot() . $path;

        /** @var string */
        $expect = file_get_contents($expect);

        $expect = str_replace("\r\n", "\n", $expect);
        // ----------------------------------------------

        // Find the actual generated file -------------------
        $path = '/tests/Fixture/Templates/TestValidator.php';

        $actual = $this->getRoot() . $path;

        /** @var string */
        $actual = file_get_contents($actual);

        $actual = str_replace("\r\n", "\n", $actual);
        // --------------------------------------------------

        $this->assertEquals($expect, $actual);

        unlink($file);
    }

    /**
     * @return void
     */
    public function test_passed_if_check_created()
    {
        // Run the command from the console app ---
        $command = $this->app->find('make:check');

        $command = new CommandTester($command);

        $data = array('name' => 'TestCheck');

        $command->execute($data);
        // ----------------------------------------

        // Prepare the expected file after generation ---
        $path = '/src/Checks/TestCheck.php';

        $expect = $file = $this->getRoot() . $path;

        /** @var string */
        $expect = file_get_contents($expect);

        $expect = str_replace("\r\n", "\n", $expect);
        // ----------------------------------------------

        // Find the actual generated file ---------------
        $path = '/tests/Fixture/Templates/TestCheck.php';

        $actual = $this->getRoot() . $path;

        /** @var string */
        $actual = file_get_contents($actual);

        $actual = str_replace("\r\n", "\n", $actual);
        // ----------------------------------------------

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
