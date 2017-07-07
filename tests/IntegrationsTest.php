<?php

namespace Rougin\Weasley;

class IntegrationsTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Rougin\Slytherin\Integration\Configuration
     */
    protected $config;

    /**
     * @var \Psr\Container\ContainerInterface
     */
    protected $container;

    /**
     * @var string
     */
    protected $interface = 'Psr\Container\ContainerInterface';

    /**
     * Sets up the test case.
     */
    public function setUp()
    {
        $this->container = new \Rougin\Slytherin\Container\Container;

        $this->config = new \Rougin\Slytherin\Integration\Configuration;
    }

    /**
     * Tests Illuminate\DatabaseIntegration.
     *
     * @return void
     */
    public function testIlluminateDatabase()
    {
        $integration = new Integrations\Illuminate\DatabaseIntegration;

        $this->config->set('database.sqlite.driver', 'sqlite');
        $this->config->set('database.sqlite.database', '/path/to/sqlite/database');

        $this->config->set('database.mysql.driver', 'mysql');
        $this->config->set('database.mysql.host', 'localhost');
        $this->config->set('database.mysql.username', 'root');
        $this->config->set('database.mysql.password', '');
        $this->config->set('database.mysql.database', 'test');
        $this->config->set('database.mysql.charset', 'utf8');

        $container = $integration->define($this->container, $this->config);

        $this->assertInstanceOf($this->interface, $container);
    }

    /**
     * Tests Illuminate\PaginationIntegration.
     *
     * @return void
     */
    public function testIlluminatePagination()
    {
        $message = 'Illuminate Pagination is not yet installed.';

        class_exists('Illuminate\Pagination\Paginator') || $this->markTestSkipped($message);

        $integration = new \Rougin\Slytherin\Http\HttpIntegration;

        $container = $integration->define($this->container, $this->config);

        $integration = new Integrations\Illuminate\PaginationIntegration;

        $container = $integration->define($container, $this->config);

        $paginator = Fixture\Models\User::paginate();

        $this->assertInstanceOf('Illuminate\Pagination\LengthAwarePaginator', $paginator);
    }

    /**
     * Tests Illuminate\ViewIntegration.
     *
     * @return void
     */
    public function testIlluminateView()
    {
        $integration = new Integrations\Illuminate\ViewIntegration;

        $this->config->set('illuminate.view.compiled', __DIR__ . '/Fixture/Compiled');
        $this->config->set('illuminate.view.templates', __DIR__ . '/Fixture/Templates');

        $container = $integration->define($this->container, $this->config);

        $factory = $container->get('Illuminate\Contracts\View\Factory');
        $renderer = $container->get('Rougin\Slytherin\Template\RendererInterface');

        $this->assertInstanceOf('Illuminate\Contracts\View\Factory', $factory);
        $this->assertEquals('Hello world!', $renderer->render('Hello'));
    }
}
