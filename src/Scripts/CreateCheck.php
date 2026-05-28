<?php

namespace Rougin\Weasley\Scripts;

/**
 * @package Weasley
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class CreateCheck extends AbstractMake
{
    /**
     * @var string
     */
    protected $command = 'make:check';

    /**
     * @var string
     */
    protected $message = 'Check created successfully!';

    /**
     * @var string
     */
    protected $namespace = 'App\Checks';

    /**
     * @var string
     */
    protected $path = 'src/Checks';

    /**
     * @var string
     */
    protected $text = 'Creates a new check (validation) class';

    /**
     * @return \Rougin\Classidy\Classidy
     */
    protected function stub()
    {
        $class = parent::stub();

        $class->extendsTo('Rougin\Weasley\Check');

        $value = 'array<string, string>';

        $class->addArrayProperty('labels', $value)
            ->asProtected();

        $class->addArrayProperty('rules', $value);

        return $class->asProtected();
    }
}
