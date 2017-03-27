<?php

namespace Rougin\Weasley\Fixture\Http\Controllers;

/**
 * Users Controller
 *
 * @package Weasley
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
class UsersController extends \Rougin\Weasley\Http\Controllers\RestfulController
{
    /**
     * @var string
     */
    protected $model = 'Rougin\Weasley\Fixture\Models\User';

    /**
     * @var string
     */
    protected $validator = 'Rougin\Weasley\Fixture\Validators\UserValidator';
}
