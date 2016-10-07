<?php

namespace Rougin\Weasley\Commands;

use Doctrine\Common\Inflector\Inflector;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use Rougin\Weasley\Common\Configuration;
use Rougin\Weasley\Common\AbstractCommand;

/**
 * Create Authentication Command
 *
 * @package Weasley
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
class CreateAuthenticationCommand extends AbstractCommand
{
    /**
     * @var string
     */
    protected $routesTemplate = "\n    " . '// Routes for authentication' . "\n    " .
        '[ \'GET\', \'/auth/sign-in\', [ \'{application}\{namespace}\AuthenticationController\', \'index\' ] ],' . "\n    " .
        '[ \'POST\', \'/auth/sign-in\', [ \'{application}\{namespace}\AuthenticationController\', \'authenticate\' ] ],' . "\n    " .
        '[ \'GET\', \'/auth/sign-out\', [ \'{application}\{namespace}\AuthenticationController\', \'destroy\' ] ],' . "\n";

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
                InputOption::VALUE_NONE,
                'Overwrite the specified files'
            );
    }

    /**
     * Checks whether the command is enabled or not in the current environment.
     *
     * @return boolean
     */
    public function isEnabled()
    {
        return $this->filesystem->has('public/index.php');
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
            'plural'      => lcfirst(Inflector::classify(Inflector::pluralize($input->getOption('model')))),
            'singular'    => lcfirst(Inflector::classify(Inflector::singularize($input->getOption('model')))),
            'username'    => $input->getOption('username'),
        ];

        $controller = $this->renderer->render('Authentication/AuthenticationController.php', $data);
        $middleware = $this->renderer->render('Authentication/AuthenticateMiddleware.php', $data);

        $middlewares = $this->generateFile($config, 'middleware');
        $routes      = $this->generateFile($config, 'route');

        $controllerFile = $config->folders->controllers . '/AuthenticationController.php';
        $middlewareFile = $config->folders->middlewares . '/AuthenticateMiddleware.php';

        if ($this->filesystem->has($controllerFile)) {
            if ($input->getOption('overwrite')) {
                $this->filesystem->delete($controllerFile);
            } else {
                $text = 'AuthenticationController.php already exists.';

                return $output->writeln('<error>' . $text . '</error>');
            }
        }

        if ($this->filesystem->has($middlewareFile)) {
            if ($input->getOption('overwrite')) {
                $this->filesystem->delete($middlewareFile);
            } else {
                $text = 'AuthenticateMiddleware.php already exists.';

                return $output->writeln('<error>' . $text . '</error>');
            }
        }

        $this->filesystem->write($controllerFile, $controller);
        $this->filesystem->write($middlewareFile, $middleware);

        if ($this->filesystem->has($config->files->routes)) {
            $this->filesystem->update($config->files->routes, $routes);
        }

        if ($this->filesystem->has($config->files->middlewares)) {
            $this->filesystem->update($config->files->middlewares, $middlewares);
        }

        $text = 'Basic authentication created successfully.';

        return $output->writeln('<info>' . $text . '</info>');
    }

    /**
     * Generates file contents.
     * 
     * @param  object $config
     * @param  string $type
     * @return string
     */
    protected function generateFile($config, $type)
    {
        $types = [
            'middleware' => [
                'filePath'  => $config->files->middlewares,
                'template'  => "\n    " . '\'{application}\{namespace}\AuthenticateMiddleware\',',
                'namespace' => $config->namespaces->middlewares,
            ],
            'route' => [
                'filePath'  => $config->files->routes,
                'template'  => $this->routesTemplate,
                'namespace' => $config->namespaces->controllers,
            ]
        ];

        $contents = file_get_contents($config->output . '/' . $types[$type]['filePath']);
        $lines    = preg_split("/\\r\\n|\\r|\\n/", $contents);
        $return   = array_search('return [', $lines);

        $template = $lines[$return] . $types[$type]['template'];
        $contents = str_replace($lines[$return], $template, $contents);

        $keywords = [
            '{application}' => $config->application->name,
            '{namespace}'   => $types[$type]['namespace'],
        ];

        return str_replace(array_keys($keywords), array_values($keywords), $contents);
    }
}
