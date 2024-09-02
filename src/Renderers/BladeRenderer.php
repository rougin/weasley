<?php

namespace Rougin\Weasley\Renderers;

use Illuminate\Contracts\View\Factory;
use Rougin\Slytherin\Template\RendererInterface;

/**
 * Laravel Blade Renderer
 *
 * A simple wrapper of Laravel Blade to Slytherin's RendererInterface.
 *
 * @package Weasley
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class BladeRenderer implements RendererInterface
{
    /**
     * @var \Illuminate\Contracts\View\Factory
     */
    protected $factory;

    /**
     * @param \Illuminate\Contracts\View\Factory $factory
     */
    public function __construct(Factory $factory)
    {
        $this->factory = $factory;
    }

    /**
     * Renders a template.
     *
     * @param string               $template
     * @param array<string, mixed> $data
     * @param array<string, mixed> $merge
     *
     * @return string
     */
    public function render($template, array $data = array(), $merge = array())
    {
        return $this->factory->make($template, $data, $merge)->render();
    }
}
