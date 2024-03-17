<?php

namespace Rougin\Weasley\Session;

/**
 * Session
 *
 * @package Weasley
 * @author  Rougin Gutib <rougingutib@gmail.com>
 */
class Session implements SessionInterface
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

        if ($id === null)
        {
            $this->regenerate(true);
        }
        else
        {
            $this->id = $id;
        }

        /** @var array<string, mixed> */
        $data = unserialize($handler->read($this->id));

        $this->data = $data;
    }

    /**
     * Removes the value from the specified key.
     *
     * @param  string $key
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
     * @param  string     $key
     * @param  mixed|null $default
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
     * @param  boolean $delete
     * @return boolean
     */
    public function regenerate($delete = false)
    {
        if ($delete)
        {
            $this->handler->destroy($this->id);
        }

        $serialized = serialize($this->data);

        $this->id = $this->random(40);

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
        $this->data[$key] = $value;

        $data = serialize($this->data);

        $this->handler->write($this->id, $data);

        return $this;
    }

    /**
     * NOTE: Should be in a single function (or class).
     *
     * Generates a random string.
     *
     * @param  integer $length
     * @return string
     */
    protected function random($length)
    {
        $search = array('/', '+', '=');

        $string = '';

        while (($len = strlen($string)) < $length)
        {
            $size = (int) ($length - $len);

            /** @var string */
            $bytes = openssl_random_pseudo_bytes($length * 2);

            if (function_exists('random_bytes'))
            {
                $bytes = call_user_func('random_bytes', $size);
            }

            $bytes = base64_encode($bytes);

            $text = str_replace($search, '', $bytes);

            $string .= substr($text, 0, $size);
        }

        return $string;
    }
}
