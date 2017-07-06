<?php

namespace Rougin\Weasley\Template;

/**
 * Illuminate's View (Blade) Renderer
 *
 * A simple implementation of a renderer using Laravel Blade.
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
     * @return string
     */
    public function render($template, array $data = array())
    {
        return $this->factory->make($template, $data)->render();
    }
}
