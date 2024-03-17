<?php

namespace Rougin\Weasley;

use LegacyPHPUnit\TestCase as Legacy;

/**
 * @package Weasley
 * @author  Rougin Gutib <rougingutib@gmail.com>
 *
 * @codeCoverageIgnore
 */
class Testcase extends Legacy
{
    public function setExpectedException($exception)
    {
        if (method_exists($this, 'expectException'))
        {
            $this->expectException($exception);

            return;
        }

        /** @phpstan-ignore-next-line */
        parent::setExpectedException($exception);
    }
}
