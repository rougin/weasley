<?php

namespace Rougin\Weasley\Fixture;

/**
 * No Validator Controller
 *
 * @package Weasley
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
class NoValidatorController extends \Rougin\Weasley\Http\Controllers\RestfulController
{
    /**
     * @var string
     */
    protected $model = 'Rougin\Weasley\Fixture\UserModel';
}
