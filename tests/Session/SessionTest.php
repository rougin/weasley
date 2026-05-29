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
    protected $self;

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

        $actual = $this->self->get('undefined', $expect);

        $this->assertEquals($expect, $actual);
    }

    /**
     * @runInSeparateProcess
     *
     * @return void
     */
    public function test_passed_if_id_regenerated()
    {
        $expect = $this->self->id();

        $this->self->regenerate(true);

        $actual = $this->self->id();

        $this->assertNotEquals($expect, $actual);
    }

    /**
     * @runInSeparateProcess
     *
     * @return void
     */
    public function test_passed_if_key_deleted()
    {
        $this->self->set('deleted', true);

        $this->self->delete('deleted');

        $actual = $this->self->get('deleted');

        $this->assertNull($actual);
    }

    /**
     * @runInSeparateProcess
     *
     * @return void
     */
    public function test_passed_if_nonexistent_deleted()
    {
        $actual = $this->self->delete('nonexistent');

        $this->assertFalse($actual);
    }

    /**
     * @runInSeparateProcess
     *
     * @return void
     */
    public function test_passed_if_regenerated_keep_data()
    {
        $expect = $this->self->id();

        $this->self->set('keep', 'value');

        $this->self->regenerate(false);

        $actual = $this->self->id();

        $this->assertNotEquals($expect, $actual);

        $expect = 'value';

        $actual = $this->self->get('keep');

        $this->assertEquals($expect, $actual);
    }

    /**
     * @runInSeparateProcess
     *
     * @return void
     */
    public function test_passed_if_set_fluent()
    {
        $actual = $this->self->set('chain', 'test');

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

        $this->self->set('test', $expect);

        $actual = $this->self->get('test');

        $this->assertEquals($expect, $actual);
    }

    /**
     * @return void
     */
    protected function doSetUp()
    {
        parent::doSetUp();

        $app = new SessionIntegration;

        $new = new Container;

        $app = $app->define($new, $this->config);

        /** @var \Rougin\Weasley\Session\Session */
        $self = $app->get(self::SESSION);

        $this->self = $self;
    }
}
