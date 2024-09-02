<?php

namespace Rougin\Weasley\Session;

use Rougin\Weasley\Assorted\Random;
use Rougin\Weasley\Contract\Session as Contract;

/**
 * Session
 *
 * @package Weasley
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class Session implements Contract
{
    /**
     * @var array<string, mixed>
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
     * Initializes the session instance.
     *
     * @param \SessionHandlerInterface $handler
     * @param string|null              $id
     */
    public function __construct(\SessionHandlerInterface $handler, $id = null)
    {
        $this->handler = $handler;

        if ($id)
        {
            $this->id = $id;

            /** @var array<string, mixed> */
            $data = unserialize($handler->read($this->id));

            $this->data = $data;
        }
    }

    /**
     * Removes the value from the specified key.
     *
     * @param string $key
     *
     * @return boolean
     */
    public function delete($key)
    {
        $result = false;

        if (isset($this->data[$key]) === true)
        {
            unset($this->data[$key]);

            $serialized = (string) serialize($this->data);

            $this->handler->write($this->id, $serialized);

            $result = true;
        }

        return $result;
    }

    /**
     * Returns the value from the specified key.
     *
     * @param string     $key
     * @param mixed|null $default
     *
     * @return mixed
     */
    public function get($key, $default = null)
    {
        $exists = isset($this->data[$key]) === true;

        return $exists ? $this->data[$key] : $default;
    }

    /**
     * Returns the session ID.
     *
     * @return string
     */
    public function id()
    {
        return $this->id;
    }

    /**
     * Updates the current session ID with a newly generated one.
     *
     * @param boolean $delete
     *
     * @return boolean
     */
    public function regenerate($delete = false)
    {
        if ($delete)
        {
            $this->handler->destroy($this->id);
        }

        $serialized = serialize($this->data);

        $this->id = Random::make(40);

        $this->handler->write($this->id, $serialized);

        return true;
    }

    /**
     * Sets the value to the specified key.
     *
     * @param string $key
     * @param mixed  $value
     *
     * @return self
     */
    public function set($key, $value)
    {
        $this->data[$key] = $value;

        $data = serialize($this->data);

        $this->handler->write($this->id, $data);

        return $this;
    }
}
