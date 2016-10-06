<?php

namespace Rougin\Weasley\Common;

use Twig_Environment;
use Rougin\Describe\Describe;
use League\Flysystem\Filesystem;
use Symfony\Component\Console\Command\Command;

/**
 * Abstract Command
 *
 * Extends the Symfony\Console\Command class with Twig's renderer.
 * 
 * @package Weasley
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
abstract class AbstractCommand extends Command
{
    /**
     * @var \Rougin\Describe\Describe
     */
    protected $describe;

    /**
     * @var \League\Flysystem\Filesystem
     */
    protected $filesystem;

    /**
     * @var \Twig_Environment
     */
    protected $renderer;

    /**
     * @param \Rougin\Describe\Describe    $describe
     * @param \League\Flysystem\Filesystem $filesystem
     * @param \Twig_Environment            $renderer
     */
    public function __construct(Describe $describe, Filesystem $filesystem, Twig_Environment $renderer)
    {
        parent::__construct();

        $this->describe   = $describe;
        $this->filesystem = $filesystem;
        $this->renderer   = $renderer;
    }
}
