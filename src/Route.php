<?php

namespace Rougin\Weasley;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Rougin\Weasley\Transformer\JsonTransformer;

/**
 * Route
 *
 * @package Weasley
 * @author  Rougin Gutib <rougingutib@gmail.com>
 */
class Route
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
     * Initializes the controller instance.
     *
     * @param \Psr\Http\Message\ServerRequestInterface $request
     * @param \Psr\Http\Message\ResponseInterface      $response
     */
    public function __construct(ServerRequestInterface $request, ResponseInterface $response)
    {
        $parsed = $request->getParsedBody();

        is_null($parsed) && $parsed = array();

        $this->request = $request->withParsedBody($parsed);

        $this->response = $response;
    }

    /**
     * Sets the server request instance.
     *
     * @param  \Psr\Http\Message\ServerRequestInterface $request
     * @return self
     */
    public function request(ServerRequestInterface $request)
    {
        $this->request = $request;

        return $this;
    }

    /**
     * Returns the specified data to JSON.
     * NOTE: Must be moved to JsonController in v1.0.0.
     * The visibility of this method must also be "protected".
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
