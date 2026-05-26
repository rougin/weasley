<?php

namespace Rougin\Weasley\Fixture\Controllers;

use Rougin\Weasley\Http\Controllers\RestfulController;

/**
 * @package Weasley
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class NoModelController extends RestfulController
{
    /**
     * @var string
     */
    protected $validator = 'Rougin\Weasley\Fixture\Validators\UserValidator';
}
