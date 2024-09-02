<?php

namespace Rougin\Weasley\Fixture\Checks;

use Rougin\Weasley\Check;

/**
 * User Check
 *
 * @package Weasley
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class UserCheckWithData extends Check
{
    /**
     * @var array<string, mixed>
     */
    protected $data = array(
        'name' => 'Rougin',
        'password' => '1234',
    );

    /**
     * @var array<string, string>
     */
    protected $labels = array(
        'name' => 'Name',
        'username' => 'Username',
        'password' => 'Password',
    );

    /**
     * @var array<string, string>
     */
    protected $rules = array(
        'name' => 'required',
        'username' => 'required',
        'password' => 'required',
    );
}
