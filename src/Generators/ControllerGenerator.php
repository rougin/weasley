<?php

namespace Rougin\Weasley\Generators;

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
        "\n    " . '// Routes for {pluralTitleDescription} Controller' . "\n    " .
        '[ \'GET\', \'/{plural}\', [ \'{application}\{namespace}\{pluralTitle}Controller\', \'index\' ], config(\'middlewares\') ],' . "\n    " .
        '[ \'GET\', \'/{plural}/create\', [ \'{application}\{namespace}\{pluralTitle}Controller\', \'create\' ], config(\'middlewares\') ],' . "\n    " .
        '[ \'POST\', \'/{plural}\', [ \'{application}\{namespace}\{pluralTitle}Controller\', \'store\' ], config(\'middlewares\') ],' . "\n    " .
        '[ \'GET\', \'/{plural}/:id/edit\', [ \'{application}\{namespace}\{pluralTitle}Controller\', \'edit\' ], config(\'middlewares\') ],' . "\n    " .
        '[ \'PUT\', \'/{plural}/:id\', [ \'{application}\{namespace}\{pluralTitle}Controller\', \'update\' ], config(\'middlewares\') ],' . "\n    " .
        '[ \'DELETE\', \'/{plural}/:id\', [ \'{application}\{namespace}\{pluralTitle}Controller\', \'delete\' ], config(\'middlewares\') ],' . "\n";

    /**
     * @param \Rougin\Describe\Describe $describe
     */
    public function __construct(Describe $describe)
    {
        $this->describe = $describe;
    }

    /**
     * Returns the required data for model.
     * 
     * @return void
     */
    public function concat(array &$data)
    {
        $config = Configuration::get();
        $columns = $this->describe->getTable($data['name']);

        $data['repository'] = (object) [
            'compacts'  => (object) [
                'create' => [],
                'edit'   => '',
            ],
            'dropdowns' => '',
            'name'      => 'repository',
        ];

        $data['parameters'] = '';

        foreach ($columns as $column) {
            if (strpos($column->getDataType(), 'blob') !== false) {
                $data['parameters'] = "\n\n        " . '$files = request()->getUploadedFiles();';
            }
        }

        foreach ($columns as $column) {
            if ($column->isForeignKey()) {
                $referencedTable = $this->stripTableSchema($column->getReferencedTable());

                $keywords = [
                    '{application}'   => $config->application->name,
                    '{namespace}'     => $config->namespaces->repositories,
                    '{plural}'        => Inflector::pluralize($referencedTable),
                    '{singularTitle}' => ucfirst(Inflector::singularize($referencedTable)),
                    '{singular}'      => lcfirst(Inflector::classify(Inflector::singularize($referencedTable))),
                ];

                $data['repository']->name = lcfirst(Inflector::classify($data['singular'])) . 'Repository';

                $compact  = ', \'{plural}\'';
                $dropdown = '${plural} = repository(\'{application}\{namespace}\{singularTitle}Repository\')->findAll();' . "\n        ";

                $compact  = str_replace(array_keys($keywords), array_values($keywords), $compact);
                $dropdown = str_replace(array_keys($keywords), array_values($keywords), $dropdown);

                $data['repository']->compacts->edit .= $compact;
                $data['repository']->dropdowns      .= $dropdown;

                array_push($data['repository']->compacts->create, "'" . $keywords['{plural}'] . "'");
            }

            if (strpos($column->getDataType(), 'blob') !== false) {
                $data['parameters'] .= "\n        " . '$parameters[\'' . $column->getField() . '\'] = $files[\'' . $column->getField() . '\'];';
            }
        }

        if (! empty($data['repository']->compacts->create)) {
            $data['repository']->compacts->create = ', compact(' . implode(', ', $data['repository']->compacts->create) . ')';
        } else {
            $data['repository']->compacts->create = '';
        }

        if (! empty($data['repository']->dropdowns)) {
            $data['repository']->dropdowns = substr($data['repository']->dropdowns, 0, count($data['repository']->dropdowns) - 9);
            $data['repository']->dropdowns .= "\n        ";
        }
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

        $keywords['{pluralTitle}'] = Inflector::classify(Inflector::pluralize($tableName));
        $keywords['{pluralTitleDescription}'] = Inflector::ucwords(str_replace('_', ' ', Inflector::pluralize($tableName)));
        $keywords['{plural}']      = Inflector::pluralize($tableName);
        $keywords['{application}'] = $config->application->name;
        $keywords['{namespace}']   = $config->namespaces->controllers;

        $routeContents = str_replace(array_keys($keywords), array_values($keywords), $routeContents);
    }
}
