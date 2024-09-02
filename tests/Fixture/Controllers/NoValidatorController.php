<?php

namespace Rougin\Weasley\Fixture\Controllers;

use Rougin\Weasley\Http\Controllers\RestfulController;

/**
 * No Validator Controller
 *
 * @package Weasley
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class NoValidatorController extends RestfulController
{
    /**
     * @var string
     */
    protected $model = 'Rougin\Weasley\Fixture\Models\User';
}
