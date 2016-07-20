<?php

namespace Rougin\Weasley\Common\Generators;

use Rougin\Describe\Describe;
use Doctrine\Common\Inflector\Inflector;

use Rougin\Weasley\Common\Configuration;

/**
 * Repository Generator
 *
 * @package Weasley
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
class RepositoryGenerator extends BaseGenerator
{
    /**
     * @var \Rougin\Describe\Describe
     */
    protected $describe;

    /**
     * @var string
     */
    protected $foreignVariableTemplate = '' .
        '${referencedTable} = $this->_em->getReference({table}::class, $data[\'{name}\']);' . "\n"; 

    /**
     * @var string
     */
    protected $foreignMutatorMethodTemplate = '' .
        '${singular}->{mutatorName}(${table});' . "\n";

    /**
     * @var string
     */
    protected $mutatorMethodTemplate = '' .
        '${singular}->{mutatorName}($data[\'{name}\']);' . "\n";

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
        $counter = 0;

        $data['columns'] = '';

        foreach ($columns as $column) {
            if ( ! $column->isForeignKey()) {
                continue;
            }

            $referencedTable = $this->stripTableSchema($column->getReferencedTable());
            $template = $this->foreignVariableTemplate;

            $keywords = [
                '{name}'            => $column->getField(),
                '{referencedTable}' => $referencedTable,
                '{table}'           => ucfirst($referencedTable),
            ];

            $template = str_replace(array_keys($keywords), array_values($keywords), $template);

            $data['foreignClasses'] .= "\nuse " . $config->defaults->application . '\\' .
                $config->namespaces->models . '\\' . ucfirst($referencedTable) . ';';

            $data['columns'] .= $template;

            if ($counter < (count($columns) - 1)) {
                $data['columns'] .= '        ';
            }

            $counter++;
        }

        if ($data['columns'] != '') {
            $data['columns'] .= "\n        ";
        }

        $counter = 0;

        foreach ($columns as $column) {
            if ($column->isPrimaryKey()) {
                continue;
            }

            $keywords = [
                '{name}'        => $column->getField(),
                '{mutatorName}' => Inflector::camelize('set_' . $column->getField()),
                '{singular}'    => strtolower($data['singular']),
            ];

            $template = $this->mutatorMethodTemplate;

            if ($column->isForeignKey()) {
                $referencedTable = $this->stripTableSchema($column->getReferencedTable());
                $template = $this->foreignMutatorMethodTemplate;

                $keywords['{table}'] = $referencedTable;
                $keywords['{mutatorName}'] = Inflector::camelize('set_' . $referencedTable);
            }

            $template = str_replace(array_keys($keywords), array_values($keywords), $template);

            $data['columns'] .= $template;

            if ($counter < (count($columns) - 1)) {
                $data['columns'] .= '        ';
            }

            $counter++;
        }

        $data['columns'] = trim($data['columns']);
    }
}
