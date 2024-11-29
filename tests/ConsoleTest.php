<?php

namespace Rougin\Weasley;

/**
 * @package Weasley
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class ConsoleTest extends Testcase
{
    /**
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
     * @return string
     */
    protected function changelog()
    {
        /** @var string[] */
        $file = file(__DIR__ . '/../CHANGELOG.md');

        $file = str_replace('## [', '', $file[4]);

        return substr($file, 0, 5);
    }
}
