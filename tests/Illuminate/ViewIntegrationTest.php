<?php

namespace Rougin\Weasley\Illuminate;

use Rougin\Slytherin\Container\Container;
use Rougin\Slytherin\Integration\Configuration;

/**
 * Illuminate View Integration Test
 *
 * @package Weasley
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class ViewIntegrationTest extends \Rougin\Weasley\Testcase
{
    const RENDERER = 'Rougin\Slytherin\Template\RendererInterface';

    /**
     * Sets up the integration instance.
     *
     * @return void
     */
    protected function doSetUp()
    {
        $message = 'Illuminate\View is not yet installed.';

        $class = 'Illuminate\View\Factory';

        class_exists($class) || $this->markTestSkipped($message);
    }

    /**
     * Tests IntegrationInterface::define.
     *
     * @return void
     */
    public function testDefineMethod()
    {
        list($config, $view) = array(new Configuration, new ViewIntegration);

        $compiled = __DIR__ . '/../Fixture/Storage/Compiled';

        $templates = __DIR__ . '/../Fixture/Templates';

        $config->set('illuminate.view.compiled', $compiled);

        $config->set('illuminate.view.templates', $templates);

        $container = $view->define(new Container, $config);

        $expected = 'Hello world!';

        /** @var \Rougin\Slytherin\Template\RendererInterface */
        $renderer = $container->get(self::RENDERER);

        $result = $renderer->render('Hello');

        $this->assertEquals($expected, $result);
    }
}
