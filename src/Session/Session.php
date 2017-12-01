<?php

namespace Rougin\Weasley\Session;

/**
 * Session
 *
 * @package Weasley
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
class Session implements SessionInterface
{
    /**
     * @var array
     */
    protected $data = array();

    /**
     * @var string
     */
    protected $id;

    /**
     * @var \SessionHandlerInterface
     */
    protected $handler;

    /**
     * @param \SessionHandlerInterface $handler
     * @param string|null              $id
     */
    public function __construct(\SessionHandlerInterface $handler, $id = null)
    {
        $this->handler = $handler;

        $this->id = $id;

        is_null($id) && $this->regenerate(true);

        $this->data = unserialize($handler->read($id));
    }

    /**
     * Returns the value from the specified key.
     *
     * @param  string $key
     * @return boolean
     */
    public function delete($key)
    {
        ! array_get($this->data, $key) || array_forget($this->data, $key);

        $serialized = serialize($this->data);

        $this->handler->write($this->id, $serialized);

        return true;
    }

    /**
     * Returns the value from the specified key.
     *
     * @param  string     $key
     * @param  mixed|null $default
     * @return mixed
     */
    public function get($key, $default = null)
    {
        return array_get($this->data, $key, $default);
    }

    /**
     * Updates the current session ID with a newly generated one.
     *
     * @param  boolean $delete
     * @return boolean
     */
    public function regenerate($delete = false)
    {
        $delete && $this->handler->destroy($this->id);

        $serialized = serialize($this->data);

        $this->id = str_random(40);

        $this->handler->write($this->id, $serialized);

        return true;
    }

    /**
     * Sets the value to the specified key.
     *
     * @param  string $key
     * @param  mixed  $value
     * @return self
     */
    public function set($key, $value)
    {
        $this->data = array_add($this->data, $key, $value);

        $serialized = serialize($this->data);

        $this->handler->write($this->id, $serialized);

        return $this;
    }
}
