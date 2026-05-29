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
    public function test_passed_if_integration_defined()
    {
        $container = new Container;

        $fn = array($this->integration, 'define');

        $container = $fn($container, $this->config);

        /** @var \Rougin\Weasley\Contract\Session */
        $session = $container->get(self::SESSION);

        $expect = 'Ron Weasley';

        $session->set('user.name', $expect);

        /** @var string */
        $actual = $session->get('user.name');

        $this->assertEquals($expect, $actual);
    }
}
