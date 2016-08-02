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
        $config      = Configuration::get();
        $columns     = $this->describe->getTable($data['name']);
        $counter     = 0;
        $foreignKeys = 0;

        $data['singular']      = lcfirst(Inflector::classify($data['singular']));
        $data['createColumns'] = '';
        $data['updateColumns'] = '';

        foreach ($columns as $column) {
            if ($column->isForeignKey()) {
                $foreignKeys++;
            }
        }

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

            $data['foreignClasses'] .= "\nuse " . $config->application->name . '\\' .
                $config->namespaces->models . '\\' . ucfirst($referencedTable) . ';';

            $data['createColumns'] .= $template;
            $data['updateColumns'] .= $template;

            if ($counter < $foreignKeys - 1) {
                $data['createColumns'] .= '        ';
                $data['updateColumns'] .= '        ';
            }

            $counter++;
        }

        if ($data['createColumns'] != '') {
            $data['createColumns'] .= "\n        ";
            $data['updateColumns'] .= "\n        ";
        }

        $counter = 0;

        foreach ($columns as $column) {
            if ($column->isPrimaryKey()) {
                continue;
            }

            $keywords = [
                '{name}'        => $column->getField(),
                '{mutatorName}' => Inflector::camelize('set_' . $column->getField()),
                '{singular}'    => lcfirst($data['singularTitle']),
            ];

            $template = $this->mutatorMethodTemplate;

            if ($column->isForeignKey()) {
                $referencedTable = $this->stripTableSchema($column->getReferencedTable());
                $template = $this->foreignMutatorMethodTemplate;

                $keywords['{table}'] = lcfirst(Inflector::classify($referencedTable));
                $keywords['{mutatorName}'] = Inflector::camelize('set_' . $referencedTable);
            }

            if ($column->getField() == 'datetime_created' || $column->getField() == 'datetime_updated') {
                $template = str_replace('$data[\'{name}\']', "'now'", $template);
            } else if ($column->getDataType() == 'integer' && $column->getLength() == 1) {
                $template = str_replace('$data[\'{name}\']', 'isset($data[\'{name}\'])', $template);
            } else if ($column->getField() == 'password') {
                $template = str_replace('$data[\'{name}\']', 'md5($data[\'{name}\'])', $template);
            } else if ($column->isNull()) {
                $template = str_replace('$data[\'{name}\']', 'isset($data[\'{name}\']) ? $data[\'{name}\'] : null', $template);
            }

            $template = str_replace(array_keys($keywords), array_values($keywords), $template);

            if ($column->getField() != 'datetime_updated' && strpos($column->getDataType(), 'blob') === false) {
                $data['createColumns'] .= $template;
            }

            if ($column->getField() != 'datetime_created' && $column->getField() != 'password' && strpos($column->getDataType(), 'blob') === false) {
                $data['updateColumns'] .= $template;
            }

            if ($counter < (count($columns) - 1)) {
                if ($column->getField() != 'datetime_updated' && strpos($column->getDataType(), 'blob') === false) {
                    $data['createColumns'] .= '        ';
                }

                if ($column->getField() != 'datetime_created' && $column->getField() != 'password' && strpos($column->getDataType(), 'blob') === false) {
                    $data['updateColumns'] .= '        ';
                }
            }

            $counter++;
        }

        $data['createColumns'] = trim($data['createColumns']);
        $data['updateColumns'] = trim($data['updateColumns']);

        foreach ($columns as $column) {
            if ($column->getField() != 'password' && strpos($column->getDataType(), 'blob') === false) {
                continue;
            }

            if ($column->getField() == 'password') {
                $table = lcfirst(Inflector::classify($data['singular']));
                $mutator = Inflector::camelize('set_' . $column->getField());

                $data['updateColumns'] .= "\n\n        " .
                    'if ($data[\'' . $column->getField() . '\']) {' . "\n            " .
                        '$' . $table . '->' . $mutator . '(md5($data[\'' . $column->getField() . '\']));' . "\n        " .
                    '}';
            }

            if (strpos($column->getDataType(), 'blob') !== false) {
                $table = lcfirst(Inflector::classify($data['singular']));
                $mutator = Inflector::camelize('set_' . $column->getField());

                $code = "\n\n        " .
                    'if ( ! $data[\'' . $column->getField() . '\']->getError()) {' . "\n            " .
                        '$' . $column->getField() . ' = $data[\'' . $column->getField() . '\']->getStream()->getContents();' . "\n\n            " . 
                        '$' . $table . '->' . $mutator . '($' . $column->getField() . ');' . "\n        " .
                    '}';

                $data['createColumns'] .= $code;
                $data['updateColumns'] .= $code;
            }
        }
    }
}
