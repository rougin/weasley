<?php

namespace Rougin\Weasley\Common;

/**
 * Configuration
 *
 * Gets all configurations from a .yml file.
 *
 * @package Weasley
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
class Configuration
{
    /**
     * Returns the specified configurations.
     * 
     * @return object
     */
    public static function get()
    {
        $file = file_get_contents(BLUEPRINT_FILENAME);
        $file = str_replace('%%CURRENT_DIRECTORY%%', getcwd(), $file);
        
        return \Symfony\Component\Yaml\Yaml::parse($file, false, false, true);
    }
}
