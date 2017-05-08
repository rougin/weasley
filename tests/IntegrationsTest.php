<?php

namespace Rougin\Weasley;

class IntegrationsTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Tests Illuminate\DatabaseIntegration.
     *
     * @return void
     */
    public function testIlluminateDatabase()
    {
        $config = array('database' => array());

        $config['database'] = array('default' => 'mysql');

        $config['database']['sqlite'] = array();

        $config['database']['sqlite']['driver'] = 'sqlite';
        $config['database']['sqlite']['database'] = '/path/to/sqlite/database';

        $config['database']['mysql'] = array();

        $config['database']['mysql']['driver'] = 'mysql';
        $config['database']['mysql']['host'] = 'localhost';
        $config['database']['mysql']['username'] = 'root';
        $config['database']['mysql']['password'] = '';
        $config['database']['mysql']['database'] = 'test';
        $config['database']['mysql']['charset'] = 'utf8';

        $container = new \Rougin\Slytherin\Container\Container;

        $config = new \Rougin\Slytherin\Integration\Configuration($config);

        $integration = new Integrations\Illuminate\DatabaseIntegration;

        $interface = 'Psr\Container\ContainerInterface';

        $this->assertInstanceOf($interface, $integration->define($container, $config));
    }
}
