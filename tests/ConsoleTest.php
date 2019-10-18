<?php

namespace Rougin\Weasley;

/**
 * Console Application Test
 *
 * @package Weasley
 * @author  Rougin Gutib <rougingutib@gmail.com>
 */
class ConsoleTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Tests Console::getVersion.
     *
     * @return void
     */
    public function testGetVersionMethod()
    {
        $expected = $this->changelog();

        $app = new Console;

        $result = $app->getVersion();

        $this->assertEquals($expected, $result);
    }

    /**
     * Returns the latest version from CHANGELOG.md.
     *
     * @return string
     */
    protected function changelog()
    {
        $file = file(__DIR__ . '/../CHANGELOG.md');

        $file = str_replace('## [', '', $file[4]);

        return substr($file, 0, 5);
    }
}
