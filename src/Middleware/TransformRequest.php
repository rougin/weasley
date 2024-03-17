<?php

namespace Rougin\Weasley\Middleware;

use Psr\Http\Message\ServerRequestInterface;
use Rougin\Slytherin\Middleware\HandlerInterface;
use Rougin\Slytherin\Middleware\MiddlewareInterface;

/**
 * Transform Request Middleware
 *
 * @package Weasley
 * @author  Rougin Gutib <rougingutib@gmail.com>
 */
class TransformRequest implements MiddlewareInterface
{
    /**
     * Process an incoming server request and return a response, optionally
     * delegating to the next middleware component to create the response.
     *
     * @param  \Psr\Http\Message\ServerRequestInterface      $request
     * @param  \Rougin\Slytherin\Middleware\HandlerInterface $handler
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function process(ServerRequestInterface $request, HandlerInterface $handler)
    {
        $get = $this->map($request->getQueryParams());

        $request = $request->withQueryParams($get);

        $post = $request->getParsedBody();

        $post = $this->map(is_array($post) ? $post : array());

        $post = $request->withParsedBody($post);

        return $handler->handle($post);
    }

    /**
     * Maps the array to transform each value.
     *
     * @param  array $items
     * @return array
     */
    protected function map(array $items)
    {
        foreach ((array) $items as $key => $value)
        {
            $new = $this->transform($value);

            is_array($value) && $new = $this->map($value);

            $items[$key] = $new;
        }

        return $items;
    }

    /**
     * Transforms the specified value.
     *
     * @param  mixed $value
     * @return mixed
     */
    protected function transform($value)
    {
        return $value;
    }
}
