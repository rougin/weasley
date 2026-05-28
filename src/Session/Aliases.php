<?php

/**
 * This file is only to be used for "PHPstan".
 * For its autoloading, kindly see "Interop".
 */

// @codeCoverageIgnoreStart
use Rougin\Weasley\Session\Interop;

$base = 'Rougin\Weasley\Session';

$number = Interop::isVersion2() ? '\V2' : '\V1';

$orig = $base . $number . '\FileSessionHandler';
class_alias($orig, $base . '\NewFileSessionHandler');
// @codeCoverageIgnoreEnd
