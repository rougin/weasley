<?php

namespace Rougin\Weasley\Commands;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class MakeControllerCommand extends \Symfony\Component\Console\Command\Command
{
    /**
     * Sets the configurations of the current command.
     *
     * @return void
     */
    protected function configure()
    {
        $this->setName('make:controller');
        $this->setDescription('Creates a new HTTP controller.');
    }

    /**
     * Executes the current command.
     *
     * @param  \Symfony\Component\Console\Input\InputInterface  $input
     * @param  \Symfony\Component\Console\Input\OutputInterface $output
     * @return void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->write('Controller created successfully!');
    }
}
