<?php

namespace Rougin\Weasley\Fixture;

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
    protected $model = 'Rougin\Weasley\Fixture\UserModel';

    /**
     * @var string
     */
    protected $validator = 'Rougin\Weasley\Fixture\UserValidator';
}
