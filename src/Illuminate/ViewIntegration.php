<?php

namespace Rougin\Weasley\Illuminate;

use Illuminate\Container\Container;
use Illuminate\Events\Dispatcher;
use Illuminate\Filesystem\Filesystem;
use Illuminate\View\Compilers\BladeCompiler;
use Illuminate\View\Engines\CompilerEngine;
use Illuminate\View\Engines\EngineResolver;
use Illuminate\View\Factory;
use Illuminate\View\FileViewFinder;
use Rougin\Slytherin\Container\ContainerInterface;
use Rougin\Slytherin\Integration\Configuration;
use Rougin\Slytherin\Integration\IntegrationInterface;
use Rougin\Weasley\Renderers\BladeRenderer;

/**
 * Illuminate's View Integration
 *
 * An integration for Laravel's View package (illuminate/view).
 *
 * @package Weasley
 * @author  Rougin Gutib <rougingutib@gmail.com>
 */
class ViewIntegration implements IntegrationInterface
{
    const VIEW_FACTORY = 'Illuminate\Contracts\View\Factory';

    const RENDERER = 'Rougin\Slytherin\Template\RendererInterface';

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
        $filesystem = new Filesystem;

        list($compiled, $templates) = $this->locations($config);

        $resolver = $this->resolver($compiled, $filesystem);

        $dispatcher = new Dispatcher(new Container);

        $finder = new FileViewFinder($filesystem, $templates);

        $factory = new Factory($resolver, $finder, $dispatcher);

        $container->set(self::VIEW_FACTORY, $factory);

        $renderer = new BladeRenderer($factory);

        return $container->set(self::RENDERER, $renderer);
    }

    /**
     * Returns the EngineResolver instance.
     *
     * @param  string php                        $callback
     * @param  \Illuminate\Filesystem\Filesystem $filesystem
     * @return callback
     */
    protected function resolver($compiled, $filesystem)
    {
        $resolver = new EngineResolver;

        $callback = function () use ($compiled, $filesystem) {
            $blade = new BladeCompiler($filesystem, $compiled);

            return new CompilerEngine($compiler = $blade);
        };

        $resolver->register('blade', $callback);

        return $resolver;
    }

    /**
     * Returns the compiled and template locations.
     *
     * @param  \Rougin\Slytherin\Integration\Configuration $config
     * @return array
     */
    protected function locations(Configuration $config)
    {
        $view = 'illuminate.view';

        $templates = $config->get($view . '.templates', array());

        $compiled = $config->get($view . '.compiled', '');

        is_string($templates) && $templates = array($templates);

        return array($compiled, $templates);
    }
}
