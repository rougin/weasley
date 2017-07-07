<?php

namespace Rougin\Weasley;

use Rougin\Slytherin\Container\ContainerInterface;

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

        $this->config->set('database.default', 'sqlite');

        $this->config->set('database.sqlite.driver', 'sqlite');
        $this->config->set('database.sqlite.database', __DIR__ . '/Fixture/Database.sqlite');

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
        $class = 'Illuminate\Pagination\LengthAwarePaginator';

        $message = 'Illuminate Pagination is not yet installed.';

        class_exists($class) || $this->markTestSkipped($message);

        $integration = new \Rougin\Slytherin\Http\HttpIntegration;

        $container = $integration->define($this->container, $this->config);

        $integration = new Integrations\Illuminate\PaginationIntegration;

        $container = $integration->define($container, $this->config);

        $paginator = Fixture\Models\User::paginate();

        $this->assertInstanceOf($class, $paginator);
    }

    /**
     * Tests Illuminate\ViewIntegration.
     *
     * @return void
     */
    public function testIlluminateView()
    {
        $message = 'Illuminate View is not yet installed';

        class_exists('Illuminate\View\Factory') || $this->markTestSkipped($message);

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
