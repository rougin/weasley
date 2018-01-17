<?php

namespace Rougin\Weasley\Session;

use Rougin\Slytherin\Container\Container;

/**
 * Session Integration Test
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
        $container = $this->integration->define(new Container, $this->config);

        $session = $container->get(self::SESSION);

        $expected = 'Ron Weasley';

        $session->set('user.name', $expected);

        $result = $session->get('user.name');

        $this->assertEquals($expected, $result);
    }
}
