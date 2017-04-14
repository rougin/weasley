<?php

namespace Rougin\Weasley\Commands;

use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class MakeValidatorCommand extends \Symfony\Component\Console\Command\Command
{
    /**
     * Sets the configurations of the current command.
     *
     * @return void
     */
    protected function configure()
    {
        $this->setName('make:validator')->setDescription('Creates a new validator.');
        $this->addArgument('name', InputArgument::REQUIRED, 'Name of the class.');
        $this->addOption('namespace', null, InputOption::VALUE_OPTIONAL, 'Namespace of the class.', 'Skeleton\Validators');
        $this->addOption('package', null, InputOption::VALUE_OPTIONAL, 'Name of the package.', 'Skeleton');
        $this->addOption('author', null, InputOption::VALUE_OPTIONAL, 'Name of the author.', 'Rougin Royce Gutib <rougingutib@gmail.com>');
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
        $path = getcwd() . '/Validators';

        $stub = $this->generate($input);

        file_exists($path) || mkdir($path, 0777, true);

        $file = $path . '/' . $input->getArgument('name') . '.php';

        file_put_contents($file, $stub);

        $output->write('Validator created successfully!');
    }

    /**
     * Generates a new stub based on the input.
     *
     * @param  \Symfony\Component\Console\Input\InputInterface $input
     * @return string
     */
    public function generate(InputInterface $input)
    {
        $stub = file_get_contents(__DIR__ . '/../Templates/Validator.stub');

        $stub = str_replace('$CLASS', $input->getArgument('name'), $stub);
        $stub = str_replace('$NAMESPACE', $input->getOption('namespace'), $stub);
        $stub = str_replace('$PACKAGE', $input->getOption('package'), $stub);
        $stub = str_replace('$AUTHOR', $input->getOption('author'), $stub);

        return $stub;
    }
}
