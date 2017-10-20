<?php

namespace Rougin\Weasley\Session;

/**
 * Session Interface
 *
 * @package Weasley
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
interface SessionInterface
{
	/**
     * Returns the value from the specified key.
     *
     * @param  string $key
     * @return boolean
     */
    public function delete($key);

    /**
     * Returns the value from the specified key.
     *
     * @param  string     $key
     * @param  mixed|null $default
     * @return mixed
     */
    public function get($key, $default = null);

    /**
     * Updates the current session ID with a newly generated one.
     *
     * @param  boolean $delete
     * @return boolean
     */
    public function regenerate($delete = false);

    /**
     * Sets the value to the specified key.
     *
     * @param  string $key
     * @param  mixed  $value
     * @return self
     */
    public function set($key, $value);
}
