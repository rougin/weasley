<?php

namespace Rougin\Weasley\Session;

/**
 * @package Weasley
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class Interop
{
    /**
     * "SessionHandlerInterface" is an internal PHP interface
     * with tentative return types that are not reported by
     * "hasReturnType". Use "ReturnTypeWillChange" attribute
     * for its existence instead.
     *
     * @return boolean
     */
    public static function isVersion2()
    {
        return class_exists('ReturnTypeWillChange', false);
    }

    /**
     * @param string $name
     *
     * @return void
     */
    public static function register($name)
    {
        $class = get_called_class();

        $pos = strrpos($class, '\\');

        $ns = $pos !== false ? substr($class, 0, $pos) : '';

        $num = static::isVersion2() ? '\V2' : '\V1';

        $orig = $ns . $num . '\\' . $name;

        class_alias($orig, $ns . '\New' . $name);
    }
}
