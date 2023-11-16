<?php

namespace Rougin\Weasley\Session;

use Rougin\Slytherin\Container\Container;

/**
 * Session Test
 *
 * @package Weasley
 * @author  Rougin Gutib <rougingutib@gmail.com>
 */
class SessionTest extends AbstractTestCase
{
    /**
     * @var \Rougin\Weasley\Session\SessionInterface
     */
    protected $session;

    /**
     * Sets up the session instance.
     *
     * @return void
     */
    protected function doSetUp()
    {
        parent::setUp();

        $container = new Container;

        $container = $this->integration->define($container, $this->config);

        $this->session = $container->get(self::SESSION);
    }

    /**
     * Tests SessionInterface::delete.
     *
     * @runInSeparateProcess
     *
     * @return void
     */
    public function testDeleteMethod()
    {
        $this->session->set('deleted', true);

        $this->session->delete('deleted');

        $this->assertNull($this->session->get('deleted'));
    }

    /**
     * Tests SessionInterface::get.
     *
     * @runInSeparateProcess
     *
     * @return void
     */
    public function testGetMethod()
    {
        $expected = 'Lorem ipsum dolor sit amet';

        $this->session->set('test', $expected);

        $result = $this->session->get('test');

        $this->assertEquals($expected, $result);
    }

    /**
     * Tests SessionInterface::regenerate.
     *
     * @runInSeparateProcess
     *
     * @return void
     */
    public function testRegenerateMethod()
    {
        $expected = $this->session->id();

        $this->session->regenerate(true);

        $result = $this->session->id();

        $this->assertNotEquals($expected, $result);
    }
}
