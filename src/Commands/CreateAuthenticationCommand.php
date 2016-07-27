<?php

namespace Rougin\Weasley\Commands;

use Doctrine\Common\Inflector\Inflector;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use Rougin\Weasley\Common\Configuration;
use Rougin\Weasley\Common\Commands\AbstractCommand;

/**
 * Create Authentication Command
 *
 * @package Weasley
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
class CreateAuthenticationCommand extends AbstractCommand
{
    /**
     * Configures the current command.
     *
     * @return void
     */
    protected function configure()
    {
        $this->setName('make:auth')
            ->setDescription('Creates a basic authentication')
            ->addOption(
                'model',
                null,
                InputOption::VALUE_REQUIRED,
                'Name of the model to be used',
                'user'
            )->addOption(
                'username',
                null,
                InputOption::VALUE_REQUIRED,
                'Column name for "username" field',
                'username'
            )->addOption(
                'password',
                null,
                InputOption::VALUE_REQUIRED,
                'Column name for "password" field',
                'password'
            )->addOption(
                'overwrite',
                null,
                InputOption::VALUE_REQUIRED,
                'Overwrite the specified files',
                false
            );
    }

    /**
     * Executes the command.
     * 
     * @param  \Symfony\Component\Console\Input\InputInterface   $input
     * @param  \Symfony\Component\Console\Output\OutputInterface $output
     * @return object|\Symfony\Component\Console\Output\OutputInterface
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $config = Configuration::get();

        $data = [
            'application' => $config->application,
            'author'      => $config->author,
            'model'       => $input->getOption('model'),
            'namespaces'  => $config->namespaces,
            'password'    => $input->getOption('password'),
            'plural'      => Inflector::pluralize($input->getOption('model')),
            'singular'    => Inflector::singularize($input->getOption('model')),
            'username'    => $input->getOption('username'),
        ];

        $controller = $this->renderer->render('Authentication/AuthenticationController.php', $data);
        $validator  = $this->renderer->render('Authentication/SignInValidator.php', $data);

        $controllerFile = $config->folders->controllers . '/AuthenticationController.php';
        $validatorFile = $config->folders->validators . '/SignInValidator.php';

        if ($this->filesystem->has($controllerFile) && ! $input->getOption('overwrite')) {
            $text = 'AuthenticationController.php already exists.';

            return $output->writeln('<error>' . $text . '</error>');
        }

        if ($this->filesystem->has($validatorFile) && ! $input->getOption('overwrite')) {
            $text = 'SignInValidator.php already exists.';

            return $output->writeln('<error>' . $text . '</error>');
        }

        $this->filesystem->write($controllerFile, $controller);
        $this->filesystem->write($validatorFile, $validator);

        $text = 'Base authentication created successfully.';

        return $output->writeln('<info>' . $text . '</info>');
    }
}
