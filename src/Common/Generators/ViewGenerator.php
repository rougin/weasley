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

            // column is a boolean (tinyint)
            if ($column->getDataType() == 'integer' && $column->getLength() == 1) {
                $template = str_replace(
                    [ '<input type="text" name="{name}" class="form-control" value="{{ session.old.{name} }}" />', '{columnTitle}'], 
                    [ '<input type="checkbox" name="{name}" />', '{columnTitle}?' ], 
                    $template);
            } else if ($column->getField() == 'password') {
                if ($type == 'edit') {
                    $template = str_replace(' value="{{ item.{name} }}"', '', $template);
                }

                $template = str_replace('type="text"', 'type="password"', $template);
            }

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

        $actions = '' .
            '<td>' . "\n              " .
                '<a href="{{ (\'/' . Inflector::pluralize($data['{name}']) . '/\' ~ item.id ~ \'/edit\') | url }}" class="btn btn-xs btn-info">' . "\n                " .
                    '<i class="icon ion-edit"></i> Update' . "\n              " .
                '</a>' . "\n               " .
                '<form action="{{ (\'/' . Inflector::pluralize($data['{name}']) . '/\' ~ item.id) | url }}" style="display: inline-block" method="POST">' . "\n                 " .
                    '<input type="hidden" name="_method" value="DELETE" />' . "\n                " .
                    '<button type="submit" class="btn btn-xs btn-danger">' . "\n                   " .
                        '<i class="icon ion-trash-b"></i> Delete' . "\n                 " .
                    '</button>' . "\n              " .
                '</form>' . "\n            " .
            '</td>';

        array_push($tableBody, $actions);

        $data['{columnForm}']   = trim($data['{columnForm}']);
        $data['{tableHeading}'] = implode("\n          ", $tableHeading);
        $data['{tableBody}']    = implode("\n            ", $tableBody);

        $item = file_get_contents($templatesPath . '/Views/' . $type . '.twig');
        $item = str_replace(array_keys($data), array_values($data), $item);

        return $item;
    }
}