<?php

namespace Rougin\Weasley\Session;

/**
 * File Session Handler
 *
 * @package Weasley
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class FileSessionHandler implements \SessionHandlerInterface
{
    /**
     * @var string
     */
    protected $data = '';

    /**
     * @var string
     */
    protected $path = '';

    /**
     * Closes the current session.
     *
     * @return boolean
     */
    public function close()
    {
        return true;
    }

    /**
     * Destroys a session.
     *
     * @param string $id
     *
     * @return boolean
     */
    public function destroy($id)
    {
        $file = $this->path . '/' . $id;

        file_exists($file) && unlink($file);

        return $this->close();
    }

    /**
     * Cleans up expired sessions.
     *
     * @param integer $lifetime
     *
     * @return boolean
     */
    public function gc($lifetime)
    {
        /** @var string $file */
        foreach ((array) glob($this->path) as $file)
        {
            $time = ((int) filemtime($file)) + $lifetime;

            $expired = $time < time();

            $exists = ! is_dir($file) && file_exists($file);

            $expired && $exists && unlink((string) $file);
        }

        return true;
    }

    /**
     * Re-initialize existing session, or creates a new one.
     *
     * @param string $path
     * @param string $id
     *
     * @return boolean
     */
    public function open($path, $id)
    {
        $file = (string) $path . '/' . $id;

        $this->path = (string) $path;

        is_dir($path) || mkdir($path, 777);

        file_exists($file) || touch($file);

        return true;
    }

    /**
     * Reads the session data from the session storage, and returns the results.
     *
     * @param string $id
     *
     * @return string
     */
    public function read($id)
    {
        $file = $this->path . '/' . $id;

        if (file_exists($file))
        {
            /** @var string */
            $data = file_get_contents($file);

            $this->data = $data;
        }

        return $this->data;
    }

    /**
     * Writes the session data to the session storage.
     *
     * @param string $id
     * @param string $data
     *
     * @return boolean
     */
    public function write($id, $data)
    {
        $file = (string) $this->path . '/' . $id;

        $result = file_put_contents($file, $data);

        return $result !== false;
    }
}
