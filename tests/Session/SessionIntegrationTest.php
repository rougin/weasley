<?php

namespace Rougin\Weasley\Session;

use Rougin\Slytherin\Container\Container;

/**
 * @package Weasley
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
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

        /** @var \Rougin\Weasley\Contract\Session */
        $session = $container->get(self::SESSION);

        $expected = 'Ron Weasley';

        $session->set('user.name', $expected);

        /** @var string */
        $result = $session->get('user.name');

        $this->assertEquals($expected, $result);
    }
}
