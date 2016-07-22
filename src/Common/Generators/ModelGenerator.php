<?php

namespace Rougin\Weasley\Common\Generators;

use Rougin\Describe\Column;
use Rougin\Describe\Describe;
use Doctrine\Common\Inflector\Inflector;

use Rougin\Weasley\Common\Configuration;

/**
 * Model Generator
 *
 * @package Weasley
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
class ModelGenerator extends BaseGenerator
{
    /**
     * @var \Rougin\Describe\Describe
     */
    protected $describe;

    /**
     * @var string
     */
    protected $columnTemplate = '' .
        "/**\n" .
        "     * @Id @GeneratedValue\n" .
        "     * @Column(name=\"{name}\", type=\"{datatype}\", length={length})\n" .
        "     */\n" .
        '    private ${variable};';

    /**
     * @var string
     */
    protected $foreignColumnTemplate = '' .
        "\n\n    /**\n" .
        "     * @ManyToOne(targetEntity=\"{referencedTable}\")\n" .
        "     * @JoinColumn(name=\"{name}\", referencedColumnName=\"{primaryKey}\", onDelete=\"cascade\")\n" .
        "     */\n" .
        '    private ${variable};';

    /**
     * @var string
     */
    protected $accessorMethodTemplate = '' .
        "/**\n" .
        "     * Gets the {description}.\n" .
        "     *\n" .
        "     * @return {datatype}\n" .
        "     */\n" .
        '    public function {accessorName}()' . "\n" .
        '    {' . "\n" .
        '        return $this->{variable};' . "\n" .
        '    }' . "\n";

    /**
     * @var string
     */
    protected $mutatorMethodTemplate = '' .
        "/**\n" .
        "     * Sets the {description}.\n" .
        "     *\n" .
        '     * @param  {datatype} ${variable}' . "\n" .
        "     * @return self\n" .
        "     */\n" .
        '    public function {mutatorName}({class}${variable})' . "\n" .
        '    {' . "\n" .
        '        $this->{variable} = ${variable};' . "\n\n" .
        '        return $this;' . "\n" .
        '    }' . "\n";

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
        $data['methods'] = '';

        foreach ($columns as $column) {
            $template = $this->columnTemplate;

            if ( ! $column->isPrimaryKey()) {
                $search = "     * @Id @GeneratedValue\n";
                $replace = '';

                $template = str_replace($search, $replace, $template);

                if ( ! $column->isForeignKey()) {
                    $data['methods'] .= $this->mutatorMethodTemplate . "\n    ";
                } else {
                    $data['foreignClasses'] .= "\nuse Doctrine\ORM\Mapping\ManyToOne;\n" .
                        "use Doctrine\ORM\Mapping\JoinColumn;";
                }
            }

            $data['methods'] .= $this->accessorMethodTemplate;

            $keywords = [
                '{name}'         => $column->getField(),
                '{datatype}'     => $column->getDataType(),
                '{length}'       => $column->getLength(),
                '{variable}'     => Inflector::camelize($column->getField()),
                '{description}'  => str_replace('_', ' ', Inflector::tableize($column->getField())),
                '{accessorName}' => Inflector::camelize('get_' . $column->getField()),
                '{mutatorName}'  => Inflector::camelize('set_' . $column->getField()),
                '{class}'        => '',
            ];

            if ($column->getField() == 'datetime_created' || $column->getField() == 'datetime_updated') {
                // $keywords['{datatype}'] = '\DateTime';

                if (strpos($data['foreignClasses'], "\nuse DateTime;") === false) {
                    $data['foreignClasses'] .= "\nuse DateTime;";
                }

                $data['methods'] = str_replace('@param  {datatype}', '@param  \DateTime', $data['methods']);
                $data['methods'] = str_replace('@return {datatype}', '@return \DateTime', $data['methods']);
                $data['methods'] = str_replace('= ${variable};', '= new DateTime(${variable});', $data['methods']);
            }

            $template = str_replace(array_keys($keywords), array_values($keywords), $template);
            $data['methods'] = str_replace(array_keys($keywords), array_values($keywords), $data['methods']);

            $data['columns'] .= $template;

            $this->setForeignKey($column, $data, $keywords);

            if ($counter < (count($columns) - 1)) {
                $data['columns'] .= "\n\n" . '    ';
                $data['methods'] .= "\n" . '    ';
            }

            $counter++;
        }

        $data['methods'] = trim($data['methods']);
    }

    /**
     * Sets specified fields for foreign key values.
     * 
     * @param \Rougin\Describe\Column $column
     */
    public function setForeignKey(Column $column, array &$data, array &$keywords)
    {
        if ( ! $column->isForeignKey()) {
            return;
        }

        $config = Configuration::get();
        $template = $this->foreignColumnTemplate;

        $data['methods'] .= "\n    " . $this->mutatorMethodTemplate . "\n    ";
        $data['methods'] .= $this->accessorMethodTemplate;

        $referencedTable = $this->stripTableSchema($column->getReferencedTable());

        $keywords['{accessorName}']    = Inflector::camelize('get_' . $referencedTable);
        $keywords['{mutatorName}']     = Inflector::camelize('set_' . $referencedTable);
        $keywords['{primaryKey}']      = $this->describe->getPrimaryKey($referencedTable);
        $keywords['{variable}']        = $referencedTable;
        $keywords['{referencedTable}'] = ucfirst($referencedTable);
        $keywords['{description}']     = $referencedTable;
        $keywords['{class}']           = ucfirst($referencedTable) . ' ';
        $keywords['{datatype}']        = '\\' . $config->application->name . '\\' .
            $config->namespaces->models . '\\' . ucfirst($referencedTable);

        $template = str_replace(array_keys($keywords), array_values($keywords), $template);
        $data['methods'] = str_replace(array_keys($keywords), array_values($keywords), $data['methods']);

        $data['columns'] .= $template;
    }
}
