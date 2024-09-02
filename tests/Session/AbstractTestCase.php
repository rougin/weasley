<?php

namespace Rougin\Weasley\Session;

use Rougin\Slytherin\Integration\Configuration;

/**
 * Abstract Test Case
 *
 * @package Weasley
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
abstract class AbstractTestCase extends \Rougin\Weasley\Testcase
{
    const SESSION = 'Rougin\Weasley\Contract\Session';

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
    protected function doSetUp()
    {
        $interface = 'SessionHandlerInterface';

        if (! interface_exists($interface))
        {
            $this->markTestSkipped('SessionHandlerInterface is not yet installed.');
        }

        $path = __DIR__ . '/../Fixture/Storage/Sessions';

        $data = array('session' => array('path' => $path));

        $this->config = new Configuration($data);

        $this->integration = new SessionIntegration;
    }
}
