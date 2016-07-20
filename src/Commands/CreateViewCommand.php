<?php

namespace Rougin\Weasley\Commands;

use Doctrine\Common\Inflector\Inflector;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use Rougin\Weasley\Common\Configuration;
use Rougin\Weasley\Common\Commands\AbstractCommand;

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

        $data = [
            'plural'   => Inflector::pluralize($input->getArgument('name')),
            'singular' => Inflector::singularize($input->getArgument('name')),
        ];

        $contents = [
            'create' => $this->renderer->render('Views/create.twig', $data),
            'edit'   => $this->renderer->render('Views/edit.twig', $data),
            'index'  => $this->renderer->render('Views/index.twig', $data),
            'show'   => $this->renderer->render('Views/show.twig', $data),
        ];

        $fileName  = $config->folders->views . '/' . $data['plural'] . '/';

        foreach ($contents as $type => $content) {
            $view = $fileName . $type . '.twig';

            if ($this->filesystem->has($view)) {
                return $output->writeln('<error>View already exists.</error>');
            }

            $this->filesystem->write($view, $content);
        }

        return $output->writeln('<info>View created successfully.</info>');
    }
}
