<?php

namespace Rougin\Weasley\Common;

use League\Flysystem\Filesystem;

/**
 * Helpers
 *
 * Gets all configurations from a .yml file.
 *
 * @package Weasley
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
class Helpers
{
    /**
     * Find pathnames matching a pattern.
     * 
     * @param  string  $pattern
     * @param  integer $flags
     * @return array
     */
    public static function glob($pattern, $flags = 0)
    {
        $files      = glob($pattern, $flags);
        $slash      = DIRECTORY_SEPARATOR;
        $newPattern = dirname($pattern) . $slash . '*';

        foreach (glob($newPattern, GLOB_ONLYDIR|GLOB_NOSORT) as $directory) {
            $anotherPattern = $directory . $slash . basename($pattern);
            $files = array_merge($files, self::glob($anotherPattern, $flags));
        }

        return $files;
    }

    /**
     * Renders the specified templates.
     * 
     * @param  \League\Flysystem\Filesystem $filesystem
     * @param  \Twig_Environment $renderer
     * @param  array $templates
     * @param  array $data
     * @return void
     */
    public static function render(Filesystem $filesystem, \Twig_Environment $renderer, array $templates = [], array $data = [])
    {
        $slash = DIRECTORY_SEPARATOR;

        foreach ($templates as $template) {
            $sourceFile = str_replace($data['directory'] . $slash, '', $template);

            if ($filesystem->has($sourceFile)) {
                $filesystem->delete($sourceFile);
            }

            if (strpos($sourceFile, '.twig') === false) {
                $contents = $renderer->render('Application' . $slash . $sourceFile, $data);
            } else {
                $contents = file_get_contents($data['directory'] . $slash . $sourceFile);
                $contents = str_replace('{application}', $data['application']->name, $contents);
            }

            if (strpos($sourceFile, '.file') !== false) {
                $sourceFile = str_replace('.file', '', $sourceFile);
            }

            $filesystem->write($sourceFile, $contents);
        }
    }
}
