<?php

namespace Rougin\Weasley;

class WeasleyTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Tests the version of the application against CHANGELOG.md.
     *
     * @return void
     */
    public function testVersion()
    {
        $app = new Console;

        $version = $this->changelog();

        $this->assertEquals($app->getVersion(), $version);
    }

    /**
     * Returns the latest version from CHANGELOG.md.
     *
     * @return string
     */
    protected function changelog()
    {
        $changelog = file(__DIR__ . '/../CHANGELOG.md');

        $changelog = str_replace('## [', '', $changelog[4]);

        return substr($changelog, 0, 5);
    }
}
