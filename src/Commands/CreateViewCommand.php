<?php

namespace Rougin\Weasley\Commands;

use Doctrine\Common\Inflector\Inflector;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use Rougin\Weasley\Common\Configuration;
use Rougin\Weasley\Common\Commands\AbstractCommand;
use Rougin\Weasley\Common\Generators\ViewGenerator;

/**
 * Create View Command
 *
 * @package Weasley
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
class CreateViewCommand extends AbstractCommand
{
    /**
     * Configures the current command.
     *
     * @return void
     */
    protected function configure()
    {
        $this
            ->setName('make:view')
            ->setDescription('Creates a new view')
            ->addArgument(
                'name',
                InputArgument::REQUIRED,
                'Name of the view'
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
        $templates = str_replace('Commands', 'Templates', __DIR__);
        $contents = [];

        $generator = new ViewGenerator($this->describe);

        $data = [
            '{name}'        => $input->getArgument('name'),
            '{pluralTitle}' => Inflector::pluralize(ucfirst($input->getArgument('name'))),
            '{plural}'      => Inflector::pluralize($input->getArgument('name')),
            '{singular}'    => Inflector::singularize($input->getArgument('name')),
        ];

        $contents['create'] = $generator->generate($data, $templates, 'create');
        $contents['edit']   = $generator->generate($data, $templates, 'edit');
        $contents['index']  = $generator->generate($data, $templates, 'index');
        $contents['show']   = $generator->generate($data, $templates, 'show');

        $fileName = $config->folders->views . '/' . $data['{plural}'] . '/';

        foreach ($contents as $type => $content) {
            $view = $fileName . $type . '.twig';

            if ($this->filesystem->has($view)) {
                $this->filesystem->delete($view);
                // return $output->writeln('<error>View already exists.</error>');
            }

            $this->filesystem->write($view, $content);
        }

        return $output->writeln('<info>View created successfully.</info>');
    }
}
