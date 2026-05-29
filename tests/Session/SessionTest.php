<?php

namespace Rougin\Weasley\Session;

use Rougin\Slytherin\Container\Container;

/**
 * @package Weasley
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class SessionTest extends AbstractTestCase
{
    /**
     * @var \Rougin\Weasley\Session\Session
     */
    protected $session;

    /**
     * @return void
     */
    protected function doSetUp()
    {
        parent::doSetUp();

        $container = new Container;

        $container = $this->integration->define($container, $this->config);

        /** @var \Rougin\Weasley\Session\Session */
        $session = $container->get(self::SESSION);

        $this->session = $session;
    }

    /**
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

    /**
     * @runInSeparateProcess
     *
     * @return void
     */
    public function testRegenerateMethodWithoutDelete()
    {
        $expected = $this->session->id();

        $this->session->set('keep', 'value');

        $this->session->regenerate(false);

        $result = $this->session->id();

        $this->assertNotEquals($expected, $result);

        $this->assertEquals('value', $this->session->get('keep'));
    }

    /**
     * @runInSeparateProcess
     *
     * @return void
     */
    public function testGetMethodWithDefault()
    {
        $result = $this->session->get('undefined_key', 'default_value');

        $this->assertEquals('default_value', $result);
    }

    /**
     * @runInSeparateProcess
     *
     * @return void
     */
    public function testDeleteMethodForNonExistentKey()
    {
        $result = $this->session->delete('nonexistent');

        $this->assertFalse($result);
    }

    /**
     * @runInSeparateProcess
     *
     * @return void
     */
    public function testSetMethodReturnsSelf()
    {
        $result = $this->session->set('chain', 'test');

        $this->assertInstanceOf('Rougin\Weasley\Session\Session', $result);
    }

    /**
     * @runInSeparateProcess
     *
     * @return void
     */
    public function testConstructorWithExistingData()
    {
        $path = __DIR__ . '/../Fixture/Storage/Sessions';

        $id = 'constructor_load_test';

        $handler = new FileSessionHandler;

        $handler->open($path, $id);

        $first = new Session($handler, $id);

        $first->set('persist', 'loaded');

        $second = new Session($handler, $id);

        $result = $second->get('persist');

        $this->assertEquals('loaded', $result);
    }
}
