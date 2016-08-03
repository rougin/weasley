<?php

namespace Rougin\Weasley\Common\Generators;

use Rougin\Describe\Describe;
use Doctrine\Common\Inflector\Inflector;

/**
 * Validator Generator
 *
 * @package Weasley
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
class ValidatorGenerator extends BaseGenerator
{
    /**
     * @var \Rougin\Describe\Describe
     */
    protected $describe;

    /**
     * @var string
     */
    protected $validatorTemplate = '' .
        '$validator->rule(\'required\', \'{name}\');' . "\n"; 

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
        $columns = $this->describe->getTable($data['name']);
        $counter = 0;

        $data['labels'] = '';
        $data['rules']  = '';

        foreach ($columns as $column) {
            $isBoolean = ($column->getDataType() == 'integer' && $column->getLength() == 1);

            if ($column->isPrimaryKey() || $column->isNull() || $isBoolean || strpos($column->getDataType(), 'blob') !== false) {
                continue;
            }

            $template = $this->validatorTemplate;

            $keywords = [
                '{name}'        => $column->getField(),
                '{mutatorName}' => Inflector::camelize('set_' . $column->getField()),
            ];

            $label    = ucfirst(str_replace('_', ' ', Inflector::tableize($column->getField())));
            $template = str_replace(array_keys($keywords), array_values($keywords), $template);

            if ($column->isForeignKey()) {
                $referencedTable = $this->stripTableSchema($column->getReferencedTable());
                $label = ucfirst(str_replace('_', ' ', Inflector::tableize($referencedTable)));
            }

            if ($column->getField() != 'datetime_created' && $column->getField() != 'datetime_updated' && $column->getField() != 'password') {
                $data['labels'] .= '\'' . $column->getField() . '\' => \'' . $label . '\',';
                $data['rules'] .= $template;
            }

            if ($column->getField() == 'password') {
                $data['labels'] .= '\'' . $column->getField() . '\' => \'' . $label . '\',';
                $data['labels'] .= "\n            " . '\'password_confirmation\' => \'Password confirmation\',';
            }

            if ($counter < (count($columns) - 1)) {
                if ($column->getField() != 'datetime_created' && $column->getField() != 'datetime_updated') {
                    if ($column->getField() != 'password') {
                        $data['rules']  .= '        ';
                    }

                    $data['labels'] .= "\n" . '            ';
                }
            }

            $counter++;
        }

        $data['labels'] = trim($data['labels']);
        $data['rules']  = trim($data['rules']);

        foreach ($columns as $column) {
            if ($column->getField() != 'password') {
                continue;
            }

            $data['rules']  .= "\n\n        " .
                'if (isset($data[\'password\']) && $data[\'password\'] != null || ! isset($data[\'_method\'])) { ' . "\n            " .
                    '$validator->rule(\'required\', \'password\');' . "\n            " .
                    '$validator->rule(\'equals\', \'password\', \'password_confirmation\');' . "\n        " .
                '}';
        }
    }
}
