<?php

namespace Rougin\Weasley\Illuminate;

use Rougin\Slytherin\Container\Container;
use Rougin\Slytherin\Integration\Configuration;
use Rougin\Weasley\Testcase;

/**
 * @package Weasley
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class ViewIntegrationTest extends Testcase
{
    const RENDERER = 'Rougin\Slytherin\Template\RendererInterface';

    /**
     * @return void
     */
    public function test_passed_if_integration_defined()
    {
        $config = new Configuration;

        $view = new ViewIntegration;

        $path = __DIR__ . '/../Fixture/Storage/Compiled';

        $config->set('illuminate.view.compiled', $path);

        $plates = __DIR__ . '/../Fixture/Templates';

        $config->set('illuminate.view.templates', $plates);

        $container = $view->define(new Container, $config);

        $expect = 'Hello world!';

        /** @var \Rougin\Slytherin\Template\RendererInterface */
        $renderer = $container->get(self::RENDERER);

        $actual = $renderer->render('Hello');

        $this->assertEquals($expect, $actual);
    }

    /**
     * @return void
     */
    protected function doSetUp()
    {
        $class = 'Illuminate\View\Factory';

        if (! class_exists($class))
        {
            $text = 'Illuminate\View not yet installed.';

            $this->markTestSkipped($text);
        }
    }
}
