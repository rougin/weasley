<?php

namespace Rougin\Weasley\Http\Controllers;

use Illuminate\Database\Eloquent\Model;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Base Controller
 *
 * @package Weasley
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
class BaseController
{
    /**
     * @var \Psr\Http\Message\ResponseInterface
     */
    protected $response;

    /**
     * @param \Psr\Http\Message\ResponseInterface $response
     */
    public function __construct(ResponseInterface $response)
    {
        $this->response = $response;
    }

    /**
     * Checks the property of the class if it has a value.
     *
     * @param  string $name
     * @return void
     * @throws \UnexpectedValueException
     */
    protected function checkProperty($name)
    {
        $controller = get_class($this);

        switch ($name) {
            case 'model':
                $message = 'Eloquent model ($model) must be defined in "' . $controller . '"';

                break;
            case 'validator':
                $message = '"$validator" must be defined in "' . $controller . '"';

                break;
        }

        if (empty($this->{$name}) || $this->{$name} == '') {
            throw new \UnexpectedValueException($message);
        }
    }

    /**
     * Creates/updates the data to storage.
     *
     * @param  \Psr\Http\Message\ServerRequestInterface $request
     * @param  \Illuminate\Database\Eloquent\Model      $model
     * @param  integer                                  $id
     * @return \Psr\Http\Message\ResponseInterface|\Illuminate\Database\Eloquent\Model
     */
    protected function save(ServerRequestInterface $request, Model $model, $id = null)
    {
        $parameters = $request->getParsedBody();
        $parameters = (is_null($parameters)) ? array() : $parameters;

        if (! $this->validator->validate((array) $parameters)) {
            $errors = $this->validator->errors;

            return $this->toJson($errors, 400);
        }

        if (is_null($id)) {
            $item = $model->create($parameters);

            return $this->toJson($item);
        }

        $model->find($id)->update($parameters);

        return $this->toJson(null, 204);
    }

    /**
     * Returns the specified data to JSON.
     *
     * @param  mixed   $data
     * @param  integer $code
     * @return string
     */
    protected function toJson($data, $code = 200)
    {
        $data = (is_string($data)) ? $data : json_encode($data);

        $response = $this->response->withStatus($code);

        $response->getBody()->write($data);

        return $response->withHeader('Content-Type', 'application/json');
    }
}
