<?php

namespace Rougin\Weasley\Fixture;

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
    protected $validator = 'Rougin\Weasley\Fixture\UserValidator';
}
