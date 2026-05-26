<?php

namespace Rougin\Weasley\Fixture\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @package Weasley
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class User extends Model
{
    /**
     * @var string
     */
    protected $table = 'users';

    /**
     * @var string[]
     */
    protected $fillable = array('name', 'username', 'password');

    /**
     * @var boolean
     */
    public $timestamps = false;
}
