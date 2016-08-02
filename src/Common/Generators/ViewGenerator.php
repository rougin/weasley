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
class ViewGenerator extends BaseGenerator
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
     * @var string
     */
    public $foreignColumnFormTemplate = '' .
        '<div class="form-group col-lg-4 col-md-4 col-sm-4 col-xs-12">' . "\n          " .
            '<label class="control-label">{columnTitle}</label>' . "\n          " .
            '<div>' . "\n            " .
                '<select name="{name}" class="selectpicker form-control" data-live-search="true">' . "\n              " .
                    '{% for {singular} in {plural} %}' . "\n                " .
                        '<option value="{{ {singular}.id }}" {{ session.old.{name} == {singular}.id ? \'selected\' : \'\' }}>' . "\n                  " .
                            '{{ {singular}.{description} }}' . "\n                " .
                        '</option>' . "\n              " .
                    '{% endfor %}' . "\n            " .
                '</select>' . "\n            " .
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

            $description = 'name';
            $referencedTable = '';

            $template = $this->columnFormTemplate;

            if ($column->isForeignKey()) {
                $referencedTable = $this->stripTableSchema($column->getReferencedTable());
                $foreignColumns  = $this->describe->getTable($referencedTable);
                $template        = $this->foreignColumnFormTemplate;

                foreach ($foreignColumns as $foreignColumn) {
                    if ( ! $foreignColumn->isPrimaryKey() && ! $foreignColumn->isForeignKey()) {
                        $description = $foreignColumn->getField();

                        break;
                    }
                }
            }

            if ($type == 'edit') {
                $template = str_replace('session.old.{name}', 'item.{value}', $template);
            }

            $columnBody  = Inflector::camelize($column->getField());
            $columnTitle = ucwords(str_replace('_', ' ', Inflector::tableize($column->getField())));

            if ($column->isForeignKey()) {
                $columnTitle = ucwords(str_replace('_', ' ', Inflector::tableize($referencedTable)));
                $columnBody  = Inflector::singularize($referencedTable) . '.' . $description;
            }

            if ($column->getField() != 'password') {
                array_push($tableHeading, '<td>' . $columnTitle . '</td>');

                if (strpos($column->getDataType(), 'blob') !== false) {
                    $image = '<img src="data:image/png;base64,{{ item.' . $columnBody . ' }}" height="50" width="50" />';

                    array_push($tableBody, '<td>' . $image . '</td>');
                } else {
                    array_push($tableBody, '<td>{{ item.' . $columnBody . ' }}</td>');
                }
            }

            $keywords = [
                '{columnTitle}' => $columnTitle,
                '{description}' => $description,
                '{name}'        => $column->getField(),
                '{plural}'      => Inflector::pluralize($referencedTable),
                '{singular}'    => Inflector::singularize($referencedTable),
            ];

            if ($type == 'edit') {
                $keywords['{value}'] = Inflector::camelize($keywords['{name}']);
            }

            // column is a boolean (tinyint)
            if ($column->getDataType() == 'integer' && $column->getLength() == 1) {
                $template = str_replace(
                    [ '<input type="text" name="{name}" class="form-control" value="{{ session.old.{name} }}" />', '{columnTitle}'], 
                    [ '<input type="checkbox" name="{name}" />', '{columnTitle}?' ], 
                    $template
                );

                if ($type == 'edit') {
                    $template = str_replace(
                        '<input type="text" name="{name}" class="form-control" value="{{ item.{value} }}" />', 
                        '<input type="checkbox" name="{name}" {{ item.{value} ? \'checked\' : \'\' }} />', 
                        $template
                    );
                }
            } else if ($column->getDataType() == 'date') {
                $template = str_replace('type="text"', 'type="date"', $template);
            } else if (strpos($column->getDataType(), 'blob') !== false) {
                $template = str_replace('type="text"', 'type="file"', $template);
                $template = str_replace(' class="form-control" value="{{ session.old.{name} }}"', '', $template);
                $template = str_replace(' class="form-control" value="{{ item.{value} }}"', '', $template);
            } else if ($column->getField() == 'password') {
                if ($type == 'edit') {
                    $template = str_replace(' value="{{ item.{value} }}"', '', $template);
                }

                $template = str_replace('type="text"', 'type="password"', $template);
            }

            $template = str_replace(array_keys($keywords), array_values($keywords), $template);

            $data['{columnForm}'] .= $template;

            if ($column->getField() == 'password') {
                $keywords = [
                    '{columnTitle}' => 'Confirm Password',
                    '{name}'        => 'password_confirmation',
                    'type="text"'   => 'type="password"',
                    ' value="{{ session.old.password_confirmation }}"' => '',
                ];

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
                    '<i class="fa fa-pencil fa-fw"></i> Update' . "\n              " .
                '</a>' . "\n               " .
                '<form action="{{ (\'/' . Inflector::pluralize($data['{name}']) . '/\' ~ item.id) | url }}" style="display: inline-block" method="POST" onsubmit="return confirm(\'Are you sure that you want to delete the selected item?\');">' . "\n                 " .
                    '<input type="hidden" name="_method" value="DELETE" />' . "\n                " .
                    '<button type="submit" class="btn btn-xs btn-danger">' . "\n                   " .
                        '<i class="fa fa-trash fa-fw"></i> Delete' . "\n                 " .
                    '</button>' . "\n              " .
                '</form>' . "\n            " .
            '</td>';

        array_push($tableHeading, '<td>Action</td>');
        array_push($tableBody, $actions);

        $data['{columnForm}']   = trim($data['{columnForm}']);
        $data['{tableHeading}'] = implode("\n          ", $tableHeading);
        $data['{tableBody}']    = implode("\n            ", $tableBody);

        $item = file_get_contents($templatesPath . '/Views/' . $type . '.twig');
        $item = str_replace(array_keys($data), array_values($data), $item);

        return $item;
    }
}