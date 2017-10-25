<?php

namespace Rougin\Weasley\Console\Commands;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Abstract Command
 *
 * @package Weasley
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
abstract class AbstractCommand extends \Symfony\Component\Console\Command\Command
{
    /**
     * @var string
     */
    protected $filename = '';

    /**
     * @var string
     */
    protected $message = '';

    /**
     * Executes the current command.
     *
     * @param  \Symfony\Component\Console\Input\InputInterface  $input
     * @param  \Symfony\Component\Console\Input\OutputInterface $output
     * @return void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $path = getcwd() . '/' . $input->getOption('path');

        file_exists($path) || mkdir($path, 0777, true);

        $file = $path . '/' . $input->getArgument('name') . '.php';

        file_put_contents($file, $this->stub($input));

        $output->writeln('<info>' . $this->message . '</info>');
    }

    /**
     * Generates a new stub based on the input.
     *
     * @param  \Symfony\Component\Console\Input\InputInterface $input
     * @return string
     */
    protected function stub(InputInterface $input)
    {
        $stub = file_get_contents(__DIR__ . '/../Templates/' . $this->filename);

        $stub = str_replace('$CLASS', $input->getArgument('name'), $stub);
        $stub = str_replace('$NAMESPACE', $input->getOption('namespace'), $stub);
        $stub = str_replace('$PACKAGE', $input->getOption('package'), $stub);
        $stub = str_replace('$AUTHOR', $input->getOption('author'), $stub);

        return $stub;
    }
}
