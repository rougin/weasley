<?php

namespace Rougin\Weasley\Integrations\Illuminate;

use Rougin\Slytherin\Integration\Configuration;
use Rougin\Slytherin\Container\ContainerInterface;

use Illuminate\View\Compilers\BladeCompiler;
use Illuminate\View\Engines\CompilerEngine;

/**
 * Illuminate's View Integration
 *
 * An integration for Laravel's View package (illuminate/view).
 *
 * @package Weasley
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
class ViewIntegration implements \Rougin\Slytherin\Integration\IntegrationInterface
{
    /**
     * @var string
     */
    protected $interface = 'Rougin\Slytherin\Template\RendererInterface';

    /**
     * Defines the specified integration.
     *
     * @param  \Rougin\Slytherin\Container\ContainerInterface $container
     * @param  \Rougin\Slytherin\Integration\Configuration    $config
     * @return \Rougin\Slytherin\Container\ContainerInterface
     */
    public function define(ContainerInterface $container, Configuration $config)
    {
        $filesystem = new \Illuminate\Filesystem\Filesystem;

        list($compiled, $templates) = $this->locations($config);

        $resolver = new \Illuminate\View\Engines\EngineResolver;

        $resolver->register('blade', $this->blade($compiled, $filesystem));

        $factory = $this->factory($filesystem, $resolver, $templates);

        $renderer = new \Rougin\Weasley\Template\BladeRenderer($factory);

        $container->set('Illuminate\Contracts\View\Factory', $factory);

        return $container->set($this->interface, $renderer);
    }

    /**
     * Returns the Blade compiler engine.
     *
     * @param  string php                        $callback
     * @param  \Illuminate\Filesystem\Filesystem $filesystem
     * @return callback
     */
    protected function blade($compiled, $filesystem)
    {
        return function () use ($compiled, $filesystem) {
            $compiler = new BladeCompiler($filesystem, $compiled);

            return new CompilerEngine($compiler, $filesystem);
        };
    }

    /**
     * Returns the compiled and template locations.
     * @param  \Rougin\Slytherin\Integration\Configuration $config
     * @return array
     */
    protected function locations(Configuration $config)
    {
        $compiled = $config->get('illuminate.view.compiled', '');

        $templates = $config->get('illuminate.view.templates', array());

        $templates = (is_string($templates)) ? array($templates) : $templates;

        return array($compiled, $templates);
    }

    /**
     * Generates a \Illuminate\View\Factory instance.
     *
     * @param  \Illuminate\Filesystem\Filesystem       $filesystem
     * @param  \Illuminate\View\Engines\EngineResolver $resolver
     * @param  array                                   $templates
     * @return \Illuminate\Contracts\View\Factory
     */
    protected function factory($filesystem, $resolver, $templates)
    {
        $container = new \Illuminate\Container\Container;

        $dispatcher = new \Illuminate\Events\Dispatcher($container);

        $finder = new \Illuminate\View\FileViewFinder($filesystem, $templates);

        return new \Illuminate\View\Factory($resolver, $finder, $dispatcher);
    }
}
