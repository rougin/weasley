<?php

namespace Rougin\Weasley\Common;

use Doctrine\Common\Inflector\Inflector;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use Rougin\Weasley\Generators\ModelGenerator;
use Rougin\Weasley\Generators\ValidatorGenerator;
use Rougin\Weasley\Generators\ControllerGenerator;
use Rougin\Weasley\Generators\RepositoryGenerator;

/**
 * Create Controller Command
 *
 * @package Weasley
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
class CreateCommand extends AbstractCommand
{
    /**
     * @var string
     */
    protected $description = '';

    /**
     * @var string
     */
    protected $type = '';

    /**
     * Configures the current command.
     *
     * @return void
     */
    protected function configure()
    {
        $config = Configuration::get();

        if ($this->description) {
            $this->setDescription($this->description);
        } else {
            $this->setDescription('Creates a new ' . $this->type);
        }

        $this
            ->setName('make:' . $this->type)
            ->addArgument(
                'name',
                InputArgument::REQUIRED,
                'Name of the ' . $this->type
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
        $name = $input->getArgument('name');
        $type = Inflector::pluralize($this->type);

        $data = [
            'application'    => $config->application,
            'author'         => $config->author,
            'foreignClasses' => '',
            'name'           => $input->getArgument('name'),
            'namespaces'     => $config->namespaces,
            'nameTitle'      => Inflector::classify($name),
            'plural'         => Inflector::pluralize($name),
            'pluralTitle'    => Inflector::classify(Inflector::pluralize($name)),
            'singular'       => Inflector::singularize($name),
            'singularTitle'  => Inflector::classify(Inflector::singularize($name)),
        ];

        $directory = $config->folders->$type;
        $type      = ucfirst($this->type);
        $item      = ucfirst(Inflector::pluralize($name) . $type);

        switch ($this->type) {
            case 'component':
                $item = ucfirst($name . $type);

                break;
            case 'model':
                $item = ucfirst($data['singular']);

                break;
            case 'middleware':
            case 'repository':
            case 'validator':
                $item = ucfirst(Inflector::singularize($name) . $type);

                break;
        }

        $fileName  = $directory . '/' . Inflector::classify($item) . '.php';

        switch ($this->type) {
            case 'controller':
                $generator = new ControllerGenerator($this->describe);
                $routes    = $this->filesystem->read($config->files->routes);

                $generator->concat($data);
                $generator->generateRoute($routes, $input->getArgument('name'));

                if (! $this->filesystem->has($fileName)) {
                    if ($this->filesystem->has($config->files->routes)) {
                        $this->filesystem->update($config->files->routes, $routes);
                    } else {
                        $this->filesystem->write($config->files->routes, $routes);
                    }
                }

                break;
            case 'model':
                $generator = new ModelGenerator($this->describe);

                $generator->concat($data);

                break;
            case 'repository':
                $generator = new RepositoryGenerator($this->describe);

                $generator->concat($data);

                break;
            case 'validator':
                $generator = new ValidatorGenerator($this->describe);

                $generator->concat($data);

                $validator = str_replace(Inflector::classify($item), 'BaseValidator', $fileName);

                if (! $this->filesystem->has($validator)) {
                    $content = $this->renderer->render('BaseValidator.php', $data);

                    $this->filesystem->write($validator, $content);
                }

                break;
        }

        $content = $this->renderer->render($this->type . '.php', $data);

        if ($this->filesystem->has($fileName)) {
            if (! $input->getOption('overwrite')) {
                $text = ucfirst($this->type) . ' already exists.';

                return $output->writeln('<error>' . $text . '</error>');
            } else {
                $this->filesystem->delete($fileName);
            }
        }

        $this->filesystem->write($fileName, $content);

        $text = ucfirst($this->type) . ' created successfully.';

        return $output->writeln('<info>' . $text . '</info>');
    }
}
