<?php

namespace Rougin\Weasley\Illuminate;

use Rougin\Slytherin\Container\Container;
use Rougin\Slytherin\Http\HttpIntegration;
use Rougin\Slytherin\Integration\Configuration;
use Rougin\Weasley\Fixture\Models\User;

/**
 * Illuminate Pagination Integration Test
 *
 * @package Weasley
 * @author  Rougin Gutib <rougingutib@gmail.com>
 */
class PaginationIntegrationTest extends \Rougin\Weasley\Testcase
{
    /**
     * Sets up the integration instance.
     *
     * @return void
     */
    protected function doSetUp()
    {
        $message = 'Illuminate\Pagination is not yet installed.';

        $class = 'Illuminate\Pagination\LengthAwarePaginator';

        class_exists($class) || $this->markTestSkipped($message);
    }

    /**
     * Tests IntegrationInterface::define.
     *
     * @return void
     */
    public function testDefineMethod()
    {
        $expected = 'Illuminate\Pagination\LengthAwarePaginator';

        $http = new HttpIntegration;

        $pagination = new PaginationIntegration;

        $config = new Configuration;

        $container = $http->define(new Container, $config);

        $container = $pagination->define($container, $config);

        $result = User::paginate();

        $this->assertInstanceOf($expected, $result);
    }
}
