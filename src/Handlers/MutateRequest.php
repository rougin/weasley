<?php

namespace Rougin\Weasley\Handlers;

use Psr\Http\Message\ServerRequestInterface;
use Rougin\Slytherin\Middleware\HandlerInterface;
use Rougin\Slytherin\Middleware\MiddlewareInterface;

/**
 * Mutate Request Middleware
 *
 * @package Weasley
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class MutateRequest implements MiddlewareInterface
{
    /**
     * Process an incoming server request and return a response, optionally
     * delegating to the next middleware component to create the response.
     *
     * @param \Psr\Http\Message\ServerRequestInterface      $request
     * @param \Rougin\Slytherin\Middleware\HandlerInterface $handler
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function process(ServerRequestInterface $request, HandlerInterface $handler)
    {
        /** @var array<string, string> */
        $query = $request->getQueryParams();

        $get = $this->map($query);

        $request = $request->withQueryParams($get);

        /** @var array<string, string> */
        $post = $request->getParsedBody();

        $post = $this->map($post);

        $post = $request->withParsedBody($post);

        return $handler->handle($post);
    }

    /**
     * Maps the array to mutate each value.
     *
     * @param array<string, mixed> $items
     *
     * @return array<string, mixed>
     */
    protected function map(array $items)
    {
        foreach ($items as $key => $value)
        {
            $mutated = $this->mutate($value);

            // Backward compatibility code from "mutate" ---
            if ($mutated === $value)
            {
                $mutated = $this->transform($mutated);
            }
            // ---------------------------------------------

            if (is_array($value))
            {
                $mutated = $this->map($value);
            }

            $items[$key] = $mutated;
        }

        return $items;
    }

    /**
     * @deprecated since ~0.7, use "mutate" instead.
     *
     * Transforms the specified value.
     *
     * @param mixed $value
     *
     * @return mixed
     */
    protected function transform($value)
    {
        return $value;
    }

    /**
     * Mutates the specified value.
     *
     * @param mixed $value
     *
     * @return mixed
     */
    protected function mutate($value)
    {
        return $value;
    }
}
