<?php

namespace Rougin\Weasley\Commands;

use Rougin\Weasley\Scripts\CreateCheck;

/**
 * @deprecated since v0.7, use "Scripts/CreateCheck" instead.
 *
 * Make Validator Command
 *
 * @package Weasley
 * @author  Rougin Gutib <rougingutib@gmail.com>
 */
class MakeValidatorCommand extends CreateCheck
{
    /**
     * @var string
     */
    protected $command = 'make:validator';

    /**
     * @var string
     */
    protected $filename = 'Validate.stub';

    /**
     * @var boolean
     */
    protected $deprecated = true;

    /**
     * @var string
     */
    protected $message = 'Validator created successfully!';

    /**
     * @var string
     */
    protected $namespace = 'App\Validators';

    /**
     * @var string
     */
    protected $path = 'src/Validators';

    /**
     * @var string
     */
    protected $text = 'Creates a new validator class based on Valitron';
}
