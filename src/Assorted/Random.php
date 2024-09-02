<?php

namespace Rougin\Weasley\Assorted;

/**
 * Random String
 *
 * @package Weasley
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class Random
{
    /**
     * Generates a random string.
     *
     * @param integer $length
     *
     * @return string
     */
    public static function make($length)
    {
        $search = array('/', '+', '=');

        $string = '';

        while (($len = strlen($string)) < $length)
        {
            $size = (int) ($length - $len);

            /** @var string */
            $bytes = openssl_random_pseudo_bytes($length * 2);

            // Use "random_bytes" if PHP version is ~7.0 ------
            if (function_exists('random_bytes'))
            {
                $bytes = call_user_func('random_bytes', $size);
            }
            // ------------------------------------------------

            $bytes = base64_encode($bytes);

            $text = str_replace($search, '', $bytes);

            $string .= substr($text, 0, $size);
        }

        return $string;
    }
}
