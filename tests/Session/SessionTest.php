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
     * @runInSeparateProcess
     *
     * @return void
     */
    public function test_passed_if_data_persisted()
    {
        $path = __DIR__ . '/../Fixture/Storage/Sessions';

        $id = 'constructor_load_test';

        $handler = new FileSessionHandler;

        $handler->open($path, $id);

        $first = new Session($handler, $id);

        $first->set('persist', 'loaded');

        $second = new Session($handler, $id);

        $expect = 'loaded';

        $actual = $second->get('persist');

        $this->assertEquals($expect, $actual);
    }

    /**
     * @runInSeparateProcess
     *
     * @return void
     */
    public function test_passed_if_default_returned()
    {
        $expect = 'default_value';

        $actual = $this->session->get('undefined', $expect);

        $this->assertEquals($expect, $actual);
    }

    /**
     * @runInSeparateProcess
     *
     * @return void
     */
    public function test_passed_if_id_regenerated()
    {
        $expect = $this->session->id();

        $this->session->regenerate(true);

        $actual = $this->session->id();

        $this->assertNotEquals($expect, $actual);
    }

    /**
     * @runInSeparateProcess
     *
     * @return void
     */
    public function test_passed_if_key_deleted()
    {
        $this->session->set('deleted', true);

        $this->session->delete('deleted');

        $actual = $this->session->get('deleted');

        $this->assertNull($actual);
    }

    /**
     * @runInSeparateProcess
     *
     * @return void
     */
    public function test_passed_if_nonexistent_deleted()
    {
        $actual = $this->session->delete('nonexistent');

        $this->assertFalse($actual);
    }

    /**
     * @runInSeparateProcess
     *
     * @return void
     */
    public function test_passed_if_regenerated_keep_data()
    {
        $expect = $this->session->id();

        $this->session->set('keep', 'value');

        $this->session->regenerate(false);

        $actual = $this->session->id();

        $this->assertNotEquals($expect, $actual);

        $expect = 'value';

        $actual = $this->session->get('keep');

        $this->assertEquals($expect, $actual);
    }

    /**
     * @runInSeparateProcess
     *
     * @return void
     */
    public function test_passed_if_set_fluent()
    {
        $actual = $this->session->set('chain', 'test');

        $class = 'Rougin\Weasley\Session\Session';

        $this->assertInstanceOf($class, $actual);
    }

    /**
     * @runInSeparateProcess
     *
     * @return void
     */
    public function test_passed_if_value_retrieved()
    {
        $expect = 'Lorem ipsum dolor sit amet';

        $this->session->set('test', $expect);

        $actual = $this->session->get('test');

        $this->assertEquals($expect, $actual);
    }

    /**
     * @return void
     */
    protected function doSetUp()
    {
        parent::doSetUp();

        $app = new Container;

        $fn = array($this->integration, 'define');

        $app = $fn($app, $this->config);

        /** @var \Rougin\Weasley\Session\Session */
        $session = $app->get(self::SESSION);

        $this->session = $session;
    }
}
