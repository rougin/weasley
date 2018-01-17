<?php

namespace Rougin\Weasley\Fixture\Controllers;

use Rougin\Weasley\Http\Controllers\RestfulController;

/**
 * Users Controller
 *
 * @package Weasley
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
class UsersController extends RestfulController
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
