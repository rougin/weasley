<?php

namespace Rougin\Weasley\Generators;

/**
 * Base Generator
 *
 * @package Weasley
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
class BaseGenerator
{
    /**
     * Strips the table schema from the table name.
     * 
     * @param  string $table
     * @return string
     */
    public function stripTableSchema($table)
    {
        return (strpos($table, '.') !== false)
            ? substr($table, strpos($table, '.') + 1)
            : $table;
    }
}