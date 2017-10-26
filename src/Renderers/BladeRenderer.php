<?php

namespace Rougin\Weasley\Renderers;

/**
 * Illuminate's View (Blade) Renderer
 *
 * A simple wrapper of Laravel Blade to Slytherin's RendererInterface.
 *
 * @package Weasley
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
class BladeRenderer implements \Rougin\Slytherin\Template\RendererInterface
{
    /**
     * @var \Illuminate\Contracts\View\Factory
     */
    protected $factory;

    /**
     * @param \Illuminate\Contracts\View\Factory $factory
     */
    public function __construct(\Illuminate\Contracts\View\Factory $factory)
    {
        $this->factory = $factory;
    }

    /**
     * Renders a template.
     *
     * @param  string $template
     * @param  array  $data
     * @param  array  $merge
     * @return string
     */
    public function render($template, array $data = array(), $merge = array())
    {
        $view = $this->factory->make($template, $data, $merge);

        return $view->render();
    }
}
