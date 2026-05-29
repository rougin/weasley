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
    protected $handler;

    /**
     * @var string
     */
    protected $path = '';

    /**
     * @return void
     */
    protected function doSetUp()
    {
        $interface = 'SessionHandlerInterface';

        if (! interface_exists($interface))
        {
            $this->markTestSkipped('SessionHandlerInterface is not yet installed.');
        }

        $path = __DIR__ . '/../Fixture';

        $this->path = $path . '/Storage/Sessions';

        $this->handler = new FileSessionHandler;
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

    /**
     * @return void
     */
    public function testCloseMethod()
    {
        $this->assertTrue($this->handler->close());
    }

    /**
     * @return void
     */
    public function testOpenMethod()
    {
        $id = 'test_session';

        $result = $this->handler->open($this->path, $id);

        $this->assertTrue($result);

        $this->assertTrue(is_dir($this->path));

        $this->assertTrue(file_exists($this->path . '/' . $id));
    }

    /**
     * @return void
     */
    public function testReadMethod()
    {
        $id = 'test_read';

        $this->handler->open($this->path, $id);

        $data = 'serialized_content';

        $this->handler->write($id, $data);

        $result = $this->handler->read($id);

        $this->assertEquals($data, $result);
    }

    /**
     * @return void
     */
    public function testReadMethodWithNoFile()
    {
        $id = 'nonexistent';

        $this->handler->open($this->path, $id . '_other');

        $result = $this->handler->read($id);

        $this->assertEquals('', $result);
    }

    /**
     * @return void
     */
    public function testWriteMethod()
    {
        $id = 'test_write';

        $this->handler->open($this->path, $id);

        $data = 'hello_world';

        $result = $this->handler->write($id, $data);

        $this->assertTrue($result);

        $this->assertEquals($data, $this->handler->read($id));
    }

    /**
     * @return void
     */
    public function testDestroyMethod()
    {
        $id = 'test_destroy';

        $this->handler->open($this->path, $id);

        $this->handler->write($id, 'some data');

        $this->assertTrue(file_exists($this->path . '/' . $id));

        $result = $this->handler->destroy($id);

        $this->assertTrue($result);

        $this->assertFalse(file_exists($this->path . '/' . $id));
    }

    /**
     * @return void
     */
    public function testGcMethod()
    {
        $id = 'gc_test';

        $this->handler->open($this->path, $id);

        $this->handler->write($id, 'some data');

        $this->handler->gc(3600);

        $this->assertTrue(file_exists($this->path . '/' . $id));
    }

    /**
     * @return void
     */
    public function testGcMethodWithExpiredFile()
    {
        $id = 'gc_expired';

        $this->handler->open($this->path, $id);

        $this->handler->write($id, 'old data');

        $file = $this->path . '/' . $id;

        touch($file, time() - 7200);

        $this->handler->gc(3600);

        $this->assertFalse(file_exists($file));
    }

    /**
     * @return void
     */
    public function testGcMethodWithEmptyPath()
    {
        $handler = new FileSessionHandler;

        $result = $handler->gc(3600);

        $this->assertTrue($result || is_int($result));
    }
}
