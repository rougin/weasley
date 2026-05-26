<?php

namespace Rougin\Weasley\Scripts;

use Rougin\Blueprint\Command;
use Rougin\Classidy\Classidy;
use Rougin\Classidy\Generator;

/**
 * @package Weasley
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class AbstractMake extends Command
{
    /**
     * @var string
     */
    protected $command = '';

    /**
     * @var boolean
     */
    protected $deprecated = false;

    /**
     * @var string
     */
    protected $message = '';

    /**
     * @var string
     */
    protected $namespace = '';

    /**
     * @var string
     */
    protected $path = '';

    /**
     * @var string
     */
    protected $text = '';

    /**
     * @return void
     */
    public function init()
    {
        if ($this->command)
        {
            $this->name = $this->command;
        }

        $text = $this->text;

        if ($this->deprecated)
        {
            $text = '(Deprecated) ' . $text;
        }

        $this->description = $text;

        // "Name" argument ---------------
        $text = 'Name of the class';

        $this->addArgument('name', $text);
        // -------------------------------

        // "Path" option (--path) ------------------------
        $text = 'Path for the file to be created';

        $this->addValueOption('path', $text, $this->path);
        // -----------------------------------------------

        // "Namespace" option (--namespace) --------------
        $text = 'Namespace of the class';

        $value = $this->namespace;

        $this->addValueOption('namespace', $text, $value);
        // -----------------------------------------------

        // "Package" option (--package) ---------------
        $text = 'Name of the package';

        $this->addValueOption('package', $text, 'App');
        // --------------------------------------------

        // "Author" option (--author) ------------------
        $value = 'Rougin Gutib <rougingutib@gmail.com>';

        $text = 'Name of the author';

        $this->addValueOption('author', $text, $value);
        // ---------------------------------------------
    }

    /**
     * @return integer
     */
    public function run()
    {
        /** @var string */
        $optPath = $this->getOption('path');

        $path = getcwd() . '/' . $optPath;

        file_exists($path) || mkdir($path, 0777, true);

        /** @var string */
        $argName = $this->getArgument('name');

        $file = $path . '/' . $argName . '.php';

        $class = $this->stub();

        $maker = new Generator;

        file_put_contents($file, $maker->make($class));

        $this->showPass($this->message);

        return self::RETURN_SUCCESS;
    }

    /**
     * @return \Rougin\Classidy\Classidy
     */
    protected function stub()
    {
        $class = new Classidy;

        // Set the name of the class ------
        /** @var string */
        $name = $this->getArgument('name');

        $class->setName($name);
        // --------------------------------

        // Set the namespace of the class -----
        /** @var string */
        $value = $this->getOption('namespace');

        $class->setNamespace($value);
        // ------------------------------------

        // Set the package name of the class ---
        /** @var string */
        $value = $this->getOption('package');

        $class->setPackage($value);
        // -------------------------------------

        // Set the author of the classs ----
        /** @var string */
        $value = $this->getOption('author');

        $class->setAuthor($value);
        // ---------------------------------

        return $class->setComment($name);
    }
}
