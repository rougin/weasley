<?php

namespace Rougin\Weasley\Fixture\Http\Controllers;

/**
 * No Model Controller
 *
 * @package Weasley
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
class NoModelController extends \Rougin\Weasley\Http\Controllers\RestfulController
{
    /**
     * @var string
     */
    protected $validator = 'Rougin\Weasley\Fixture\Validators\UserValidator';
}
