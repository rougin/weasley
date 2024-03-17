<?php

namespace Rougin\Weasley\Session;

use Rougin\Slytherin\Container\ContainerInterface;
use Rougin\Slytherin\Integration\Configuration;
use Rougin\Slytherin\Integration\IntegrationInterface;

/**
 * Session Integration
 *
 * Bootstraps the additional definitions and integrate it to Slytherin.
 *
 * @package Weasley
 * @author  Rougin Gutib <rougingutib@gmail.com>
 */
class SessionIntegration implements IntegrationInterface
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
        $name = $config->get('session.cookies', 'weasley_session');

        $container->set(self::HANDLER, $handler = $this->handler($config));

        if (! $cookie = $config->get("app.http.cookies.$name", null))
        {
            $expiration = $config->get('session.expiration', time() + 7200);

            setcookie($name, $cookie = $this->random(40), $expiration, '/');
        }

        $handler->open($config->get('session.path'), $cookie);

        $handler->gc(((int) $config->get('session.lifetime', 60)) * 60);

        return $container->set(self::SESSION, new Session($handler, $cookie));
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

        $handlers = $config->get('session.handlers', $items);

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
