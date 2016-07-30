<?php

namespace Rougin\Weasley\Common\Generators;

use Rougin\Describe\Column;
use Rougin\Describe\Describe;
use Doctrine\Common\Inflector\Inflector;

use Rougin\Weasley\Common\Configuration;

/**
 * Controller Generator
 *
 * @package Weasley
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
class ControllerGenerator extends BaseGenerator
{
    /**
     * @var \Rougin\Describe\Describe
     */
    protected $describe;

    /**
     * @var string
     */
    protected $routesTemplate = '' .
        "\n    " . '// Routes for {pluralTitle} Controller' . "\n    " .
        '[ \'GET\', \'/{plural}\', [ {application}\{namespace}\{pluralTitle}Controller::class, \'index\' ], config(\'middlewares\') ],' . "\n    " .
        '[ \'GET\', \'/{plural}/create\', [ {application}\{namespace}\{pluralTitle}Controller::class, \'create\' ], config(\'middlewares\') ],' . "\n    " .
        '[ \'POST\', \'/{plural}\', [ {application}\{namespace}\{pluralTitle}Controller::class, \'store\' ], config(\'middlewares\') ],' . "\n    " .
        '[ \'GET\', \'/{plural}/:id/edit\', [ {application}\{namespace}\{pluralTitle}Controller::class, \'edit\' ], config(\'middlewares\') ],' . "\n    " .
        '[ \'PUT\', \'/{plural}/:id\', [ {application}\{namespace}\{pluralTitle}Controller::class, \'update\' ], config(\'middlewares\') ],' . "\n    " .
        '[ \'DELETE\', \'/{plural}/:id\', [ {application}\{namespace}\{pluralTitle}Controller::class, \'delete\' ], config(\'middlewares\') ],' . "\n";

    /**
     * @param \Rougin\Describe\Describe $describe
     */
    public function __construct(Describe $describe)
    {
        $this->describe = $describe;
    }


    /**
     * Generates route contents.
     * 
     * @param  string $routeContents
     * @param  string $tableName
     */
    public function generateRoute(&$routeContents, $tableName)
    {
        $config = Configuration::get();
        $lines = preg_split("/\\r\\n|\\r|\\n/", $routeContents);

        $endBracket = $lines[count($lines) - 2];

        if ($endBracket != '];') {
            $endBracket = $lines[count($lines) - 1];
        }

        $template      = $this->routesTemplate . $endBracket;
        $routeContents = str_replace($endBracket, $template, $routeContents);

        $keywords = [];

        $keywords['{pluralTitle}'] = Inflector::tableize(Inflector::pluralize($tableName));
        $keywords['{pluralTitle}'] = str_replace('_', ' ', Inflector::ucwords($keywords['{pluralTitle}']));
        $keywords['{plural}']      = Inflector::pluralize($tableName);
        $keywords['{application}'] = $config->application->name;
        $keywords['{namespace}']   = $config->namespaces->controllers;

        $routeContents = str_replace(array_keys($keywords), array_values($keywords), $routeContents);
    }
}
