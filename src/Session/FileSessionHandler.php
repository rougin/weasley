<?php

namespace Rougin\Weasley\Session;

/**
 * File Session Handler
 *
 * @package Weasley
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
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
     * @param  integer $id
     * @return boolean
     */
    public function destroy($id)
    {
        $file = $this->path . '/' . $id;

        ! file_exists($file) || unlink($file);

        return true;
    }

    /**
     * Cleans up expired sessions.
     *
     * @param  integer $lifetime
     * @return boolean
     */
    public function gc($lifetime)
    {
        foreach (glob($this->path) as $file) {
            $time = filemtime($file) + $lifetime;

            $valid = $time > time() && file_exists($file);

            $valid || unlink($file);
        }

        return true;
    }

    /**
     * Re-initialize existing session, or creates a new one.
     *
     * @param  string $path
     * @param  string $id
     * @return boolean
     */
    public function open($path, $id)
    {
        $file = $path . '/' . $id;

        $this->path = $path;

        is_dir($path) || mkdir($path, 777);

        file_exists($file) || touch($file);

        return true;
    }

    /**
     * Reads the session data from the session storage, and returns the results.
     *
     * @param  integer $id
     * @return string
     */
    public function read($id)
    {
        $file = $this->path . '/' . $id;

        ! file_exists($file) || $this->data = file_get_contents($file);

        return $this->data;
    }

    /**
     * Writes the session data to the session storage.
     *
     * @param  string $id
     * @param  string $data
     * @return boolean
     */
    public function write($id, $data)
    {
        $file = $this->path . '/' . $id;

        $result = file_put_contents($file, $data);

        $this->close();

        return $result !== false;
    }
}
