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
    public function test_passed_if_integration_defined()
    {
        $config = Database::config();

        $eloquent = new DatabaseIntegration;

        $eloquent->define(new Container, $config);

        $pdo = Manager::connection()->getPdo();

        Database::migrate($pdo);

        Database::seed($pdo);

        $expect = 'Illuminate\Pagination\LengthAwarePaginator';

        $http = new HttpIntegration;

        $app = new Container;

        $app = $http->define($app, $config);

        $self = new PaginationIntegration;

        $app = $self->define($app, $config);

        $actual = User::paginate();

        $this->assertInstanceOf($expect, $actual);
    }

    /**
     * @return void
     */
    protected function doSetUp()
    {
        $class = 'Illuminate\Pagination\LengthAwarePaginator';

        if (! class_exists($class))
        {
            $text = 'Illuminate\Pagination not yet installed.';

            $this->markTestSkipped($text);
        }
    }
}
