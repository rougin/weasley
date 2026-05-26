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
    public function test_passed_if_correct_version()
    {
        $expect = $this->getChangelog();

        $app = new Console;

        $actual = $app->make()->getVersion();

        $this->assertEquals($expect, $actual);
    }

    /**
     * @return string
     */
    protected function getChangelog()
    {
        /** @var string[] */
        $file = file(__DIR__ . '/../CHANGELOG.md');

        $file = str_replace('## [', '', $file[4]);

        return substr($file, 0, 5);
    }
}
