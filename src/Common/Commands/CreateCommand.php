<?php

namespace Rougin\Weasley\Common\Commands;

use Doctrine\Common\Inflector\Inflector;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use Rougin\Weasley\Common\Configuration;
use Rougin\Weasley\Common\Generators\ModelGenerator;
use Rougin\Weasley\Common\Generators\ValidatorGenerator;
use Rougin\Weasley\Common\Generators\RepositoryGenerator;

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
                'application',
                null,
                InputOption::VALUE_OPTIONAL,
                'Name of the application',
                $config->defaults->application
            )->addOption(
                'author',
                null,
                InputOption::VALUE_OPTIONAL,
                'Author of the ' . $this->type,
                $config->defaults->author
            )->addOption(
                'email',
                null,
                InputOption::VALUE_OPTIONAL,
                'Email of the author',
                $config->defaults->email
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
            'application'    => $input->getOption('application'),
            'author'         => $input->getOption('author'),
            'email'          => $input->getOption('email'),
            'name'           => $input->getArgument('name'),
            'plural'         => Inflector::pluralize($name),
            'singular'       => Inflector::singularize($name),
            'namespaces'     => (object) $config->namespaces,
            'foreignClasses' => '',
        ];

        switch ($this->type) {
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

                break;
        }

        $directory = $config->folders->$type;
        $type      = ucfirst($this->type);
        $content   = $this->renderer->render($this->type . '.php', $data);
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

        $fileName  = $directory . '/' . $item . '.php';

        if ($this->filesystem->has($fileName)) {
            $text = ucfirst($this->type) . ' already exists.';

            return $output->writeln('<error>' . $text . '</error>');
        }

        $this->filesystem->write($fileName, $content);

        if ($this->type == 'validator') {
            $fileName = str_replace($item, 'BaseValidator', $fileName);

            if ( ! $this->filesystem->has($fileName)) {
                $content = $this->renderer->render('BaseValidator.php', $data);
                $this->filesystem->write($fileName, $content);
            }
        }

        $text = ucfirst($this->type) . ' created successfully.';

        return $output->writeln('<info>' . $text . '</info>');
    }
}
