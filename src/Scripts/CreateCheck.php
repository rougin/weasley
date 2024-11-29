<?php

namespace Rougin\Weasley\Scripts;

/**
 * @package Weasley
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class CreateCheck extends AbstractMake
{
    /**
     * @var string
     */
    protected $command = 'make:check';

    /**
     * @var string[]
     */
    protected $aliases = array('make:validator');

    /**
     * @var string
     */
    protected $filename = 'Check.stub';

    /**
     * @var string
     */
    protected $message = 'Check created successfully!';

    /**
     * @var string
     */
    protected $namespace = 'App\Checks';

    /**
     * @var string
     */
    protected $path = 'src/Checks';

    /**
     * @var string
     */
    protected $text = 'Creates a new check (validation) class based on Valitron';
}
