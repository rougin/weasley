<?php

namespace Rougin\Weasley\Scripts;

use Rougin\Classidy\Method;

/**
 * @package Weasley
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class CreateHandler extends AbstractMake
{
    /**
     * @var string
     */
    protected $command = 'make:handler';

    /**
     * @var string
     */
    protected $message = 'Handler created successfully!';

    /**
     * @var string
     */
    protected $namespace = 'App\Handlers';

    /**
     * @var string
     */
    protected $path = 'src/Handlers';

    /**
     * @var string
     */
    protected $text = 'Creates a new Slytherin Middleware class';

    /**
     * @return \Rougin\Classidy\Classidy
     */
    protected function stub()
    {
        $class = parent::stub();

        // Set the interface to the class ------------------------
        $name = 'Rougin\Slytherin\Middleware\MiddlewareInterface';

        $class->addInterface($name);
        // -------------------------------------------------------

        $comment = 'Process an incoming server request and return a response, optionally';

        $comment .= "\n" . 'delegating to the next middleware component to create the response.';

        $method = new Method('process');

        $method->setComment($comment);

        // Set the "$request" argument to the class ------
        $name = 'Psr\Http\Message\ServerRequestInterface';

        $method->addClassArgument('request', $name);
        // -----------------------------------------------

        // Set the handler interface to the class -------------
        $name = 'Rougin\Slytherin\Middleware\HandlerInterface';

        $method->addClassArgument('handler', $name);
        // ----------------------------------------------------

        // Set the interface to return of the class ---
        $name = '\Psr\Http\Message\ResponseInterface';

        $method->setReturn($name);
        // --------------------------------------------

        $method->setCodeLine(function ()
        {
            return array('//', '', 'return $handler->handle($request);');
        });

        return $class->addMethod($method);
    }
}
