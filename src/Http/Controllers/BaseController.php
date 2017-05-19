<?php

namespace Rougin\Weasley\Http\Controllers;

use Illuminate\Database\Eloquent\Model;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

use Rougin\Weasley\Validators\AbstractValidator;

/**
 * Base Controller
 *
 * @package Weasley
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
class BaseController
{
    /**
     * @var array
     */
    protected $errors = array();

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
        $this->request = $request;

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
     * Returns the specified data to JSON.
     *
     * @param  mixed   $data
     * @param  integer $code
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function json($data, $code = 200)
    {
        $response = $this->response->withStatus($code);

        $stream = json_encode($data);

        if (json_last_error() != JSON_ERROR_NONE) {
            $stream = $this->errors[json_last_error()];

            $response = $response->withStatus(400);
        }

        $response->getBody()->write($stream);

        return $response->withHeader('Content-Type', 'application/json');
    }

    /**
     * Returns the specified data to JSON.
     * NOTE: To be removed in v1.0.0. Use "json" method instead.
     *
     * @param  mixed   $data
     * @param  integer $code
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function toJson($data, $code = 200)
    {
        return $this->json($data, $code);
    }

    /**
     * Checks the property of the class if it has a value.
     *
     * @throws \UnexpectedValueException
     *
     * @param  string $name
     * @return void
     */
    protected function check($name)
    {
        $message = ($name == 'validator') ? '"$validator"' : 'Eloquent model ($model)';

        if ($this->{$name} == '') {
            $message .= ' must be defined in "' . get_class($this) . '"';

            throw new \UnexpectedValueException($message);
        }
    }

    /**
     * Creates/updates the data to storage.
     *
     * @param  \Illuminate\Database\Eloquent\Model          $model
     * @param  \Rougin\Weasley\Validators\AbstractValidator $validator
     * @param  integer                                      $id
     * @return \Psr\Http\Message\ResponseInterface
     */
    protected function save(Model $model, AbstractValidator $validator, $id = null)
    {
        $parameters = $this->request->getParsedBody();
        $parameters = (is_null($parameters)) ? array() : $parameters;

        if (! $validator->validate((array) $parameters)) {
            $errors = $validator->errors;

            return $this->toJson($errors, 400);
        }

        if (is_null($id)) {
            $item = $model->create($parameters);

            return $this->toJson($item->toArray());
        }

        $model->find($id)->update($parameters);

        return $this->toJson(null, 204);
    }
}
