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
     * @var array
     */
    protected $repositoryTemplate = [
        'constructor' => ', {singularTitle}Repository ${singular}Repository',
        'definition'  => "\n        " . '$this->{singular}Repository = ${singular}Repository;',
        'dropdown'    => '${plural} = $this->{singular}Repository->findAll();' . "\n        ",
        'namespace'   => "\n" . 'use {application}\{namespace}\{singularTitle}Repository;',
        'parameter'   => "\n    " . ' * @param \{application}\{namespace}\{singularTitle}Repository ${singular}Repository',
        'variable'    => "\n\n    " .
            '/**' . "\n    " .
             ' * @var \{application}\{namespace}\{singularTitle}Repository' . "\n    " .
             ' */' . "\n    " .
             'protected ${singular}Repository;',
    ];

    /**
     * @var \App\Repositories\UserRepository
     */
    protected $userRepository;

    /**
     * @var string
     */
    protected $routesTemplate = '' .
        "\n    " . '// Routes for {pluralTitleDescription} Controller' . "\n    " .
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
     * Returns the required data for model.
     * 
     * @return void
     */
    public function concat(array &$data)
    {
        $config = Configuration::get();
        $columns = $this->describe->getTable($data['name']);

        $data['repository'] = (object) [
            'compacts'     => (object) [
                'create' => [],
                'edit'   => '',
            ],
            'constructors' => '',
            'definitions'  => '',
            'dropdowns'    => '',
            'name'         => 'repository',
            'namespaces'   => '',
            'parameters'   => '',
            'variables'    => '',
        ];

        foreach ($columns as $column) {
            if ($column->isForeignKey()) {
                $referencedTable = $this->stripTableSchema($column->getReferencedTable());

                $keywords = [
                    '{application}'   => $config->application->name,
                    '{namespace}'     => $config->namespaces->repositories,
                    '{plural}'        => Inflector::pluralize($referencedTable),
                    '{singularTitle}' => ucfirst(Inflector::singularize($referencedTable)),
                    '{singular}'      => Inflector::singularize($referencedTable),
                ];

                $data['repository']->name = $data['singular'] . 'Repository';

                $compact     = ', \'{plural}\'';
                $constructor = $this->repositoryTemplate['constructor'];
                $definition  = $this->repositoryTemplate['definition'];
                $dropdown    = $this->repositoryTemplate['dropdown'];
                $namespace   = $this->repositoryTemplate['namespace'];
                $parameter   = $this->repositoryTemplate['parameter'];
                $variable    = $this->repositoryTemplate['variable'];

                $compact     = str_replace(array_keys($keywords), array_values($keywords), $compact);
                $constructor = str_replace(array_keys($keywords), array_values($keywords), $constructor);
                $definition  = str_replace(array_keys($keywords), array_values($keywords), $definition);
                $dropdown    = str_replace(array_keys($keywords), array_values($keywords), $dropdown);
                $namespace   = str_replace(array_keys($keywords), array_values($keywords), $namespace);
                $parameter   = str_replace(array_keys($keywords), array_values($keywords), $parameter);
                $variable    = str_replace(array_keys($keywords), array_values($keywords), $variable);

                $data['repository']->compacts->edit .= $compact;
                $data['repository']->constructors   .= $constructor;
                $data['repository']->definitions    .= $definition;
                $data['repository']->dropdowns      .= $dropdown;
                $data['repository']->namespaces     .= $namespace;
                $data['repository']->parameters     .= $parameter;
                $data['repository']->variables      .= $variable;

                array_push($data['repository']->compacts->create, "'" . $keywords['{plural}'] . "'");
            }
        }

        if ( ! empty($data['repository']->compacts->create)) {
            $data['repository']->compacts->create = ', compact(' . implode(', ', $data['repository']->compacts->create) . ')';
        }

        if ( ! empty($data['repository']->dropdowns)) {
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
