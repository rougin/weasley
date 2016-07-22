<?php

namespace Rougin\Weasley\Commands;

use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

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
        $config = Configuration::get();

        $this->setName('make:app')
            ->setDescription('Creates a base application');
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
        $templates = $this->glob($directory . $slash . '**.*');
        $result = [];

        $data = [
            'application' => $config->application,
            'author'      => $config->author,
            'namespaces'  => (object) $config->namespaces,
        ];

        foreach ($templates as $template) {
            $sourceFile = str_replace($directory . $slash, '', $template);
            $contents = $this->renderer->render('Application' . $slash . $sourceFile, $data);

            if ( ! $this->filesystem->has($sourceFile)) {
                $this->filesystem->write($sourceFile, $contents);
            }
        }

        $text = 'Application created successfully.';

        return $output->writeln('<info>' . $text . '</info>');
    }

    /**
     * Find pathnames matching a pattern.
     * 
     * @param  string  $pattern
     * @param  integer $flags
     * @return array
     */
    public function glob($pattern, $flags = 0)
    {
        $files      = glob($pattern, $flags);
        $slash      = DIRECTORY_SEPARATOR;
        $newPattern = dirname($pattern) . $slash . '*';

        foreach (glob($newPattern, GLOB_ONLYDIR|GLOB_NOSORT) as $directory) {
            $anotherPattern = $directory . $slash . basename($pattern);
            $files = array_merge($files, $this->glob($anotherPattern, $flags));
        }

        return $files;
    }
}
