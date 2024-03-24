<?php

namespace Rougin\Weasley\Routes;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Rougin\Weasley\Mutators\JsonMutator;

/**
 * HTTP Route
 *
 * @package Weasley
 * @author  Rougin Gutib <rougingutib@gmail.com>
 */
class HttpRoute
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
     * NOTE: To be changed in ~1.0, its visibility must be "protected".
     *
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

        $transformer = new JsonMutator($response, $options);

        /** @var \Psr\Http\Message\ResponseInterface */
        return $transformer->mutate($data);
    }

    /**
     * @deprecated since ~0.2, use "json" instead.
     *
     * Returns the specified data to JSON.
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
