<?php

namespace Rougin\Weasley\Common\Generators;

use Doctrine\Common\Inflector\Inflector;

use Rougin\Describe\Describe;

/**
 * View Generator
 *
 * @package Weasley
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
class ViewGenerator
{
    /**
     * @var \Rougin\Describe\Describe
     */
    protected $describe;

    /**
     * @var string
     */
    public $columnFormTemplate = '' .
        '<div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-12">' . "\n          " .
            '<label class="control-label">{columnTitle}</label>' . "\n          " .
            '<div>' . "\n            " .
                '<input type="text" name="{name}" class="form-control" value="{{ session.old.{name} }}" />' . "\n            " .
                '<small class="text-danger">{{ session.validation.{name}[0] }}</small>' . "\n          " .
            '</div>' . "\n        " .
        '</div>' . "\n";

    /**
     * @param \Rougin\Describe\Describe $describe
     */
    public function __construct(Describe $describe)
    {
        $this->describe = $describe;
    }

    /**
     * Generates a template based on type.
     *
     * @param  array  $data
     * @param  string $templatesPath
     * @param  string $type
     * @return string
     */
    public function generate($data, $templatesPath, $type)
    {
        $columns = $this->describe->getTable($data['{name}']);
        $counter = 0;
        $tableHeading = [];
        $tableBody = [];

        $data['{columnForm}'] = '';

        foreach ($columns as $column) {
            if ($column->isPrimaryKey() || $column->getField() == 'datetime_created' || $column->getField() == 'datetime_updated') {
                continue;
            }

            $template = $this->columnFormTemplate;

            if ($type == 'edit') {
                $template = str_replace('session.old.{name}', 'item.{name}', $template);
            }

            $columnTitle = ucwords(str_replace('_', ' ', Inflector::tableize($column->getField())));

            if ($column->getField() != 'password') {
                array_push($tableHeading, '<td>' . $columnTitle . '</td>');
                array_push($tableBody, '<td>{{ item.' . Inflector::camelize($column->getField()) . ' }}</td>');
            }

            $keywords = [ '{columnTitle}' => $columnTitle, '{name}' => $column->getField() ];

            $template = str_replace(array_keys($keywords), array_values($keywords), $template);

            $data['{columnForm}'] .= $template;

            if ($column->getField() == 'password') {
                $keywords = [ '{columnTitle}' => 'Confirm Password', '{name}' => 'password_confirmation' ];

                $template = str_replace(array_keys($keywords), array_values($keywords), $this->columnFormTemplate);

                $data['{columnForm}'] .= '        ' . $template;
            }

            if ($counter < (count($columns) - 1)) {
                $data['{columnForm}'] .= '        ';
            }

            $counter++;
        }

        $data['{columnForm}']   = trim($data['{columnForm}']);
        $data['{tableHeading}'] = implode("\n          ", $tableHeading);
        $data['{tableBody}']    = implode("\n            ", $tableBody);

        $item = file_get_contents($templatesPath . '/Views/' . $type . '.twig');
        $item = str_replace(array_keys($data), array_values($data), $item);

        return $item;
    }
}