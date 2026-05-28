<?php

namespace Rougin\Weasley\Illuminate;

use Illuminate\Database\Capsule\Manager;
use Rougin\Slytherin\Container\Container;
use Rougin\Slytherin\Http\HttpIntegration;
use Rougin\Weasley\Fixture\Database;
use Rougin\Weasley\Fixture\Models\User;
use Rougin\Weasley\Testcase;

/**
 * @package Weasley
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class PaginationIntegrationTest extends Testcase
{
    /**
     * @return void
     */
    protected function doSetUp()
    {
        $message = 'Illuminate\Pagination is not yet installed.';

        $class = 'Illuminate\Pagination\LengthAwarePaginator';

        class_exists($class) || $this->markTestSkipped($message);
    }

    /**
     * @return void
     */
    public function testDefineMethod()
    {
        $config = Database::config();

        $eloquent = new DatabaseIntegration;

        $eloquent->define(new Container, $config);

        $pdo = Manager::connection()->getPdo();

        Database::migrate($pdo);

        Database::seed($pdo);

        $expected = 'Illuminate\Pagination\LengthAwarePaginator';

        $http = new HttpIntegration;

        $pagination = new PaginationIntegration;

        $container = $http->define(new Container, $config);

        $container = $pagination->define($container, $config);

        $result = User::paginate();

        $this->assertInstanceOf($expected, $result);
    }
}
