<?php

namespace Rougin\Weasley\Transformer;

/**
 * Transformer Interface
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
    public function __construct(\Psr\Http\Message\ResponseInterface $response, $options = 0)
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
     * @param  mixed   $data
     * @param  integer $code
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function transform($data, $code = 200)
    {
        $response = $this->response->withStatus($code);

        $stream = json_encode($data, $this->options);

        if (json_last_error() != JSON_ERROR_NONE) {
            $stream = $this->errors[json_last_error()];

            $response = $response->withStatus(400);
        }

        $response->getBody()->write($stream);

        return $response->withHeader('Content-Type', 'application/json');
    }
}
