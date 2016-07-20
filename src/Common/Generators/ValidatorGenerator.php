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
class ValidatorGenerator
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

        $data['columns'] = '';

        foreach ($columns as $column) {
            if ($column->isPrimaryKey() || $column->isNull()) {
                continue;
            }

            $template = $this->validatorTemplate;

            $keywords = [
                '{name}'        => $column->getField(),
                '{mutatorName}' => Inflector::camelize('set_' . $column->getField()),
            ];

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
