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
    const RENDERER = 'Rougin\Slytherin\Template\RendererInterface';

    const VIEW_FACTORY = 'Illuminate\Contracts\View\Factory';

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

        $result = $this->locations($config);

        /** @var string */
        $compiled = $result['compiled'];

        /** @var string[] */
        $templates = $result['templates'];

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
     * @param  string                            $compiled
     * @param  \Illuminate\Filesystem\Filesystem $filesystem
     * @return \Illuminate\View\Engines\EngineResolver
     */
    protected function resolver($compiled, $filesystem)
    {
        $resolver = new EngineResolver;

        $callback = function () use ($compiled, $filesystem)
        {
            $blade = new BladeCompiler($filesystem, $compiled);

            return new CompilerEngine($blade);
        };

        $resolver->register('blade', $callback);

        return $resolver;
    }

    /**
     * Returns the compiled and template locations.
     *
     * @param  \Rougin\Slytherin\Integration\Configuration $config
     * @return array<string, string[]|string>
     */
    protected function locations(Configuration $config)
    {
        $view = 'illuminate.view';

        /** @var string|string[] */
        $templates = $config->get($view . '.templates', array());

        /** @var string */
        $compiled = $config->get($view . '.compiled', '');

        if (is_string($templates))
        {
            $templates = array($templates);
        }

        $result = array();

        $result['compiled'] = $compiled;

        $result['templates'] = $templates;

        return $result;
    }
}
