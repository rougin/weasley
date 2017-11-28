<?php

namespace Rougin\Weasley\Http\Middleware;

use Interop\Http\ServerMiddleware\DelegateInterface;
use Interop\Http\ServerMiddleware\MiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * "Transform Request" Middleware
 *
 * @package Weasley
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
class TransformRequest implements MiddlewareInterface
{
    /**
     * Process an incoming server request and return a response, optionally delegating
     * to the next middleware component to create the response.
     *
     * @param  \Psr\Http\Message\ServerRequestInterface         $request
     * @param  \Interop\Http\ServerMiddleware\DelegateInterface $delegate
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function process(ServerRequestInterface $request, DelegateInterface $delegate)
    {
        $get = $this->map($request->getQueryParams());

        $request = $request->withQueryParams($get);

        $post = $request->getParsedBody();

        $post = $this->map(is_array($post) ? $post : array());

        $post = $request->withParsedBody($post);

        return $delegate->process($post);
    }

    /**
     * Maps the array to transform each value.
     *
     * @param  array $items
     * @return array
     */
    protected function map(array $items)
    {
        foreach ($items as $key => $value) {
            $new = $this->transform($value);

            ! is_array($value) || $new = $this->map($value);

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
