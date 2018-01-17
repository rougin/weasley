<?php

namespace Rougin\Weasley\Session;

/**
 * Abstract Test Case
 *
 * @package Weasley
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
abstract class AbstractTestCase extends \PHPUnit_Framework_TestCase
{
    const SESSION = 'Rougin\Weasley\Session\SessionInterface';

    /**
     * Sets up the session instance.
     *
     * @return void
     */
    public function setUp()
    {
        $message = 'SessionHandlerInterface is not yet installed.';

        $interface = 'SessionHandlerInterface';

        interface_exists($interface) || $this->markTestSkipped($message);
    }
}
