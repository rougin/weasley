<?php

namespace Rougin\Weasley\Session;

use Rougin\Slytherin\Integration\Configuration;

/**
 * Abstract Test Case
 *
 * @package Weasley
 * @author  Rougin Gutib <rougingutib@gmail.com>
 */
abstract class AbstractTestCase extends \PHPUnit_Framework_TestCase
{
    const SESSION = 'Rougin\Weasley\Session\SessionInterface';

    /**
     * @var \Rougin\Slytherin\Integration\Configuration
     */
    protected $config;

    /**
     * @var \Rougin\Slytherin\Integration\IntegrationInterface
     */
    protected $integration;

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

        $path = __DIR__ . '/../Fixture/Storage/Sessions';

        $data = array('session' => array('path' => $path));

        $this->config = new Configuration($data);

        $this->integration = new SessionIntegration;
    }
}
