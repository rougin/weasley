<?php

namespace Rougin\Weasley\Transformer;

use Psr\Http\Message\ResponseInterface;

/**
 * JSON Transformer
 *
 * @package Weasley
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
class JsonTransformer implements TransformerInterface
{
    /**
     * @var array
     */
    protected $errors = array();

    /**
     * @var integer
     */
    protected $options = 0;

    /**
     * @var \Psr\Http\Message\ResponseInterface
     */
    protected $response;

    /**
     * @param \Psr\Http\Message\ResponseInterface $response
     * @param integer                             $options
     */
    public function __construct(ResponseInterface $response, $options = 0)
    {
        $this->options = $options;

        $this->response = $response;

        array_push($this->errors, 'No errors');
        array_push($this->errors, 'Maximum stack depth exceeded');
        array_push($this->errors, 'Underflow or the modes mismatch');
        array_push($this->errors, 'Unexpected control character found');
        array_push($this->errors, 'Syntax error, malformed JSON');
        array_push($this->errors, 'Malformed UTF-8 characters, possibly incorrectly encoded');
        array_push($this->errors, 'One or more recursive references in the value to be encoded');
        array_push($this->errors, 'One or more NAN or INF values in the value to be encoded');
        array_push($this->errors, 'A value of a type that cannot be encoded was given');
        array_push($this->errors, 'A property name that cannot be encoded was given');
        array_push($this->errors, 'Malformed UTF-16 characters, possibly incorrectly encoded');
    }

    /**
     * Transforms the contents of the result.
     *
     * @param  mixed $data
     * @return mixed
     */
    public function transform($data)
    {
        $response = $this->response;

        $stream = json_encode($data, $this->options);

        if (json_last_error() != JSON_ERROR_NONE) {
            $stream = $this->errors[json_last_error()];

            $response = $response->withStatus(400);
        }

        $response->getBody()->write($stream);

        return $response->withHeader('Content-Type', 'application/json');
    }
}
