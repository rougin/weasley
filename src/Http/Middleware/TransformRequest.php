<?php

namespace Rougin\Weasley\Http\Middleware;

use Psr\Http\Message\ServerRequestInterface;
use Interop\Http\ServerMiddleware\DelegateInterface;

/**
 * "Transform Request" Middleware
 *
 * @package Weasley
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
class TransformRequest implements \Interop\Http\ServerMiddleware\MiddlewareInterface
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

        $post = $this->map($request->getParsedBody() ?: array());

        $request = $request->withQueryParams($get);

        return $delegate->process($request->withParsedBody($post));
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
            $transformed = $this->transform($key, $value);

            $items[$key] = $transformed;
        }

        return $items;
    }
}
