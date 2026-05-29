<?php

namespace Rougin\Weasley\Session;

use Rougin\Weasley\Testcase;

/**
 * @package Weasley
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class FileSessionHandlerTest extends Testcase
{
    /**
     * @var \SessionHandlerInterface
     */
    protected $self;

    /**
     * @var string
     */
    protected $path = '';

    /**
     * @return void
     */
    public function test_passed_if_close_succeeds()
    {
        $this->assertTrue($this->self->close());
    }

    /**
     * @return void
     */
    public function test_passed_if_destroy_succeeds()
    {
        $id = 'test_destroy';

        $this->self->open($this->path, $id);

        $this->self->write($id, 'some data');

        $file = $this->path . '/' . $id;

        $this->assertTrue(file_exists($file));

        $actual = $this->self->destroy($id);

        $this->assertTrue($actual);

        $this->assertFalse(file_exists($file));
    }

    /**
     * @return void
     */
    public function test_passed_if_gc_cleans_normal()
    {
        $id = 'gc_test';

        $this->self->open($this->path, $id);

        $this->self->write($id, 'some data');

        $this->self->gc(3600);

        $file = $this->path . '/' . $id;

        $this->assertTrue(file_exists($file));
    }

    /**
     * @return void
     */
    public function test_passed_if_gc_deletes_expired()
    {
        $id = 'gc_expired';

        $this->self->open($this->path, $id);

        $this->self->write($id, 'old data');

        $file = $this->path . '/' . $id;

        touch($file, time() - 7200);

        $this->self->gc(3600);

        $this->assertFalse(file_exists($file));
    }

    /**
     * @return void
     */
    public function test_passed_if_gc_empty_path()
    {
        $self = new FileSessionHandler;

        $actual = $self->gc(3600);

        $this->assertTrue($actual || is_int($actual));
    }

    /**
     * @return void
     */
    public function test_passed_if_open_succeeds()
    {
        $id = 'test_session';

        $actual = $this->self->open($this->path, $id);

        $this->assertTrue($actual);

        $this->assertTrue(is_dir($this->path));

        $file = $this->path . '/' . $id;

        $this->assertTrue(file_exists($file));
    }

    /**
     * @return void
     */
    public function test_passed_if_read_missing_file()
    {
        $id = 'nonexistent';

        $this->self->open($this->path, $id . '_other');

        $actual = $this->self->read($id);

        $this->assertEquals('', $actual);
    }

    /**
     * @return void
     */
    public function test_passed_if_read_succeeds()
    {
        $id = 'test_read';

        $this->self->open($this->path, $id);

        $data = 'serialized_content';

        $this->self->write($id, $data);

        $expect = $data;

        $actual = $this->self->read($id);

        $this->assertEquals($expect, $actual);
    }

    /**
     * @return void
     */
    public function test_passed_if_write_succeeds()
    {
        $id = 'test_write';

        $this->self->open($this->path, $id);

        $data = 'hello_world';

        $actual = $this->self->write($id, $data);

        $this->assertTrue($actual);

        $expect = $data;

        $actual = $this->self->read($id);

        $this->assertEquals($expect, $actual);
    }

    /**
     * @return void
     */
    protected function doSetUp()
    {
        $interface = 'SessionHandlerInterface';

        if (! interface_exists($interface))
        {
            $text = $interface . ' not yet installed.';

            $this->markTestSkipped($text);
        }

        $path = __DIR__ . '/../Fixture';

        $this->path = $path . '/Storage/Sessions';

        $this->self = new FileSessionHandler;
    }

    /**
     * @return void
     */
    protected function doTearDown()
    {
        $ids = array('test_session');

        $ids[] = 'test_read';
        $ids[] = 'nonexistent_other';
        $ids[] = 'test_write';
        $ids[] = 'test_destroy';
        $ids[] = 'gc_test';
        $ids[] = 'gc_expired';

        foreach ($ids as $id)
        {
            $file = $this->path . '/' . $id;

            file_exists($file) && unlink($file);
        }
    }
}
