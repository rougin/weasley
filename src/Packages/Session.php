<?php

namespace Rougin\Weasley\Packages;

use Rougin\Slytherin\Container\ContainerInterface;
use Rougin\Slytherin\Integration\Configuration;
use Rougin\Slytherin\Integration\IntegrationInterface;
use Rougin\Weasley\Session\FileSessionHandler;
use Rougin\Weasley\Session\Session as WeasleySession;

/**
 * Session Package
 *
 * @package Weasley
 * @author  Rougin Gutib <rougingutib@gmail.com>
 */
class Session implements IntegrationInterface
{
    const HANDLER = 'Rougin\Weasley\Session\SessionHandlerInterface';

    const SESSION = 'Rougin\Weasley\Session\SessionInterface';

    /**
     * Defines the specified integration.
     *
     * @param  \Rougin\Slytherin\Container\ContainerInterface $container
     * @param  \Rougin\Slytherin\Integration\Configuration    $config
     * @return \Rougin\Slytherin\Container\ContainerInterface
     */
    public function define(ContainerInterface $container, Configuration $config)
    {
        /** @var string */
        $name = $config->get('session.cookies', 'weasley_session');

        $container->set(self::HANDLER, $handler = $this->handler($config));

        /** @var string|null $cookie */
        $cookie = $config->get("app.http.cookies.$name", null);

        if ($cookie === null)
        {
            $cookie = $this->random(40);

            $default = time() + 7200;

            /** @var integer */
            $expiration = $config->get('session.expiration', $default);

            setcookie($name, $cookie, $expiration, '/');
        }

        /** @var string */
        $sessionPath = $config->get('session.path');

        $handler->open($sessionPath, $cookie);

        /** @var integer */
        $lifetime = $config->get('session.lifetime', 60);

        $handler->gc($lifetime * 60);

        $session = new WeasleySession($handler, $cookie);

        return $container->set(self::SESSION, $session);
    }

    /**
     * Returns the specified SessionHandlerInterface.
     *
     * @param  \Rougin\Slytherin\Integration\Configuration $config
     * @return \SessionHandlerInterface
     */
    protected function handler(Configuration $config)
    {
        $items = array('file' => new FileSessionHandler);

        /** @var array<string, \SessionHandlerInterface> */
        $handlers = $config->get('session.handlers', $items);

        /** @var string */
        $driver = $config->get('session.driver', 'file');

        return $handlers[$driver];
    }

    /**
     * NOTE: Should be in a single function (or class).
     *
     * Generates a random string.
     *
     * @param  integer $length
     * @return string
     */
    protected function random($length)
    {
        $search = array('/', '+', '=');

        $string = '';

        while (($len = strlen($string)) < $length)
        {
            $size = (int) ($length - $len);

            /** @var string */
            $bytes = openssl_random_pseudo_bytes($length * 2);

            if (function_exists('random_bytes'))
            {
                $bytes = call_user_func('random_bytes', $size);
            }

            $bytes = base64_encode($bytes);

            $text = str_replace($search, '', $bytes);

            $string .= substr($text, 0, $size);
        }

        return $string;
    }
}
