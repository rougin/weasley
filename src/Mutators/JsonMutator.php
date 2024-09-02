<?php

namespace Rougin\Weasley\Mutators;

use Psr\Http\Message\ResponseInterface;
use Rougin\Weasley\Contract\Mutator;

/**
 * JSON Transformer
 *
 * @package Weasley
 *
 * @author Rougin Gutib <rougingutib@gmail.com>
 */
class JsonMutator implements Mutator
{
    /**
     * @var array<integer, string>
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
        $this->errors[] = 'No errors';
        $this->errors[] = 'Maximum stack depth exceeded';
        $this->errors[] = 'Underflow or the modes mismatch';
        $this->errors[] = 'Unexpected control character found';
        $this->errors[] = 'Syntax error, malformed JSON';
        $this->errors[] = 'Malformed UTF-8 characters, possibly incorrectly encoded';
        $this->errors[] = 'One or more recursive references in the value to be encoded';
        $this->errors[] = 'One or more NAN or INF values in the value to be encoded';
        $this->errors[] = 'A value of a type that cannot be encoded was given';
        $this->errors[] = 'A property name that cannot be encoded was given';
        $this->errors[] = 'Malformed UTF-16 characters, possibly incorrectly encoded';

        $this->options = $options;

        $this->response = $response;
    }

    /**
     * @deprecated since ~0.7, use "mutate" instead.
     * @codeCoverageIgnore
     *
     * Transforms the contents of the result.
     *
     * @param mixed $data
     *
     * @return mixed
     */
    public function transform($data)
    {
        return $this->mutate($data);
    }

    /**
     * Mutates the contents of the result.
     *
     * @param mixed $data
     *
     * @return mixed
     */
    public function mutate($data)
    {
        $response = $this->response;

        /** @var string */
        $stream = @json_encode($data, $this->options);

        if (json_last_error() !== JSON_ERROR_NONE)
        {
            $stream = $this->errors[json_last_error()];

            $response = $response->withStatus(400);
        }

        $response->getBody()->write($stream);

        return $response->withHeader('Content-Type', 'application/json');
    }
}
