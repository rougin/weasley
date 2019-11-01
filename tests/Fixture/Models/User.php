<?php

namespace Rougin\Weasley\Fixture\Models;

/**
 * User Model
 *
 * @package Skeleton
 * @author  Rougin Gutib <rougingutib@gmail.com>
 */
class User extends \Illuminate\Database\Eloquent\Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = array('name', 'username', 'password');

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;
}
