<?php

namespace Rougin\Weasley\Commands;

use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use Rougin\Weasley\Common\Helpers;
use Rougin\Weasley\Common\Configuration;
use Rougin\Weasley\Common\Commands\AbstractCommand;

/**
 * Create Application Command
 *
 * @package Weasley
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
class CreateApplicationCommand extends AbstractCommand
{
    /**
     * Configures the current command.
     *
     * @return void
     */
    protected function configure()
    {
        $this->setName('make:app')
            ->setDescription('Creates a base application');
    }

    /**
     * Checks whether the command is enabled or not in the current environment.
     *
     * @return boolean
     */
    public function isEnabled()
    {
        return ! $this->filesystem->has('public/index.php');
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
        $slash = DIRECTORY_SEPARATOR;

        $directory = str_replace('Commands', 'Templates' . $slash . 'Application', __DIR__);
        $templates = Helpers::glob($directory . $slash . '*.*');
        $appDirectory = $directory . $slash;
        $result = [];

        array_push($templates, $appDirectory . '.editorconfig');
        array_push($templates, $appDirectory . '.env.file');
        array_push($templates, $appDirectory . '.gitignore.file');
        array_push($templates, $appDirectory . '.htaccess');
        array_push($templates, $appDirectory . 'public' . $slash . '.htaccess');
        array_push($templates, $appDirectory . 'app' . $slash . '.htaccess');
        array_push($templates, $appDirectory . 'src' . $slash . '.htaccess');
        array_push($templates, $appDirectory . 'app' . $slash . 'database' . $slash . 'migrations' . $slash . '.gitignore');
        array_push($templates, $appDirectory . 'app' . $slash . 'database' . $slash . 'seeds' . $slash . '.gitignore');

        $data = [
            'application' => $config->application,
            'author'      => $config->author,
            'database'    => $config->database,
            'directory'   => $directory,
            'files'     => $config->files,
            'folders'     => $config->folders,
            'namespaces'  => (object) $config->namespaces,
        ];

        Helpers::render($this->filesystem, $this->renderer, $templates, $data);

        // system('composer update');

        $text = 'Application created successfully.';

        return $output->writeln('<info>' . $text . '</info>');
    }
}
