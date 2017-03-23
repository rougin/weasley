<?php

namespace Rougin\Weasley;

use Symfony\Component\Console\Tester\CommandTester;

class CommandsTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Symfony\Component\Console\Application
     */
    protected $application;

    /**
     * Sets up the application.
     *
     * @return void
     */
    public function setUp()
    {
        $application = new \Symfony\Component\Console\Application;

        $application->add(new \Rougin\Weasley\Commands\MakeControllerCommand);
        $application->add(new \Rougin\Weasley\Commands\MakeIntegrationCommand);
        $application->add(new \Rougin\Weasley\Commands\MakeValidatorCommand);
        $application->add(new \Rougin\Weasley\Commands\MakeViewCommand);

        $this->application = $application;
    }

    /**
     * Tests MakeControllerCommand.
     *
     * @return void
     */
    public function testControllerCommand()
    {
        $expected = 'Controller created successfully!';

        $command = new CommandTester($this->application->find('make:controller'));

        $command->execute(array());

        $output = $command->getDisplay();

        $this->assertContains($expected, $output);
    }

    /**
     * Tests MakeIntegrationCommand.
     *
     * @return void
     */
    public function testIntegrationCommand()
    {
        $expected = 'Integration created successfully!';

        $command = new CommandTester($this->application->find('make:integration'));

        $command->execute(array());

        $output = $command->getDisplay();

        $this->assertContains($expected, $output);
    }

    /**
     * Tests MakeValidatorCommand.
     *
     * @return void
     */
    public function testValidatorCommand()
    {
        $expected = 'Validator created successfully!';

        $command = new CommandTester($this->application->find('make:validator'));

        $command->execute(array());

        $output = $command->getDisplay();

        $this->assertContains($expected, $output);
    }

    /**
     * Tests MakeViewCommand.
     *
     * @return void
     */
    public function testViewCommand()
    {
        $expected = 'Views created successfully!';

        $command = new CommandTester($this->application->find('make:view'));

        $command->execute(array());

        $output = $command->getDisplay();

        $this->assertContains($expected, $output);
    }
}