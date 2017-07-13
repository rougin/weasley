<?php

namespace Rougin\Weasley\Http\Controllers;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

use Rougin\Weasley\Transformer\JsonTransformer;

/**
 * Base Controller
 *
 * @package Weasley
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
class BaseController
{
    /**
     * @var \Psr\Http\Message\ServerRequestInterface
     */
    protected $request;

    /**
     * @var \Psr\Http\Message\ResponseInterface
     */
    protected $response;

    /**
     * @param \Psr\Http\Message\ServerRequestInterface $request
     * @param \Psr\Http\Message\ResponseInterface      $response
     */
    public function __construct(ServerRequestInterface $request, ResponseInterface $response)
    {
        $parameters = $request->getParsedBody();

        $request = $request->withParsedBody(is_null($parameters) ? array() : $parameters);

        $this->request = $request;

        $this->response = $response;
    }

    /**
     * Returns the specified data to JSON.
     *
     * @param  mixed   $data
     * @param  integer $code
     * @param  integer $options
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function json($data, $code = 200, $options = 0)
    {
        $response = $this->response->withStatus($code);

        $transformer = new JsonTransformer($response, $options);

        return $transformer->transform($data);
    }

    /**
     * Returns the specified data to JSON.
     * NOTE: To be removed in v1.0.0. Use "json" method instead.
     *
     * @param  mixed   $data
     * @param  integer $code
     * @param  integer $options
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function toJson($data, $code = 200, $options = 0)
    {
        return $this->json($data, $code, $options);
    }
}
