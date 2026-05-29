<?php

namespace Rougin\Weasley\Session;

Interop::register('FileSessionHandler');

/**
 * @method boolean       close()
 * @method boolean       destroy(string $id)
 * @method false|integer gc(integer $max_lifetime)
 * @method boolean       open(string $path, string $name)
 * @method false|string  read(string $id)
 * @method boolean       write(string $id, string $data)
 *
 * @package Weasley
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class FileSessionHandler extends NewFileSessionHandler
{
}
