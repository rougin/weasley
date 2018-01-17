<?php

namespace Rougin\Weasley\Session;

use Rougin\Slytherin\Container\Container;
use Rougin\Slytherin\Integration\Configuration;

/**
 * Session View Integration Test
 *
 * @package Weasley
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
class SessionIntegrationTest extends AbstractTestCase
{
    /**
     * Tests IntegrationInterface::define.
     *
     * @runInSeparateProcess
     *
     * @return void
     */
    public function testDefineMethod()
    {
        $path = __DIR__ . '/../Fixture/Storage/Sessions';

        $data = array('session' => array('path' => $path));

        $config = new Configuration($data);

        $integration = new SessionIntegration;

        $container = $integration->define(new Container, $config);

        $session = $container->get(self::SESSION);

        $expected = 'Ron Weasley';

        $session->set('user.name', $expected);

        $result = $session->get('user.name');

        $this->assertEquals($expected, $result);
    }
}
