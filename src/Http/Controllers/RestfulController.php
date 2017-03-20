<?php

namespace Rougin\Weasley\Http\Controllers;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * RESTful Controller
 *
 * @package Weasley
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
class RestfulController
{
    /**
     * @var \Illuminate\Database\Eloquent\Model|string
     */
    protected $model;

    /**
     * @var \Psr\Http\Message\ServerRequestInterface
     */
    protected $request;

    /**
     * @var \Psr\Http\Message\ResponseInterface
     */
    protected $response;

    /**
     * @var \Rougin\Weasley\Validators\AbstractValidator|string
     */
    protected $validator;

    /**
     * @param \Psr\Http\Message\ServerRequestInterface $request
     * @param \Psr\Http\Message\ResponseInterface      $response
     */
    public function __construct(ServerRequestInterface $request, ResponseInterface $response)
    {
        $this->request  = $request;
        $this->response = $response;

        $controller = get_class($this);

        if (empty($this->model) || $this->model == '') {
            $message = 'Eloquent model ($model) must be defined in "' . $controller . '"';

            throw new \UnexpectedValueException($message);
        }

        $this->model = new $this->model;

        if (empty($this->validator) || $this->validator == '') {
            $message = '"$validator" must be defined in "' . $controller . '"';

            throw new \UnexpectedValueException($message);
        }

        $this->validator = new $this->model;
    }

    /**
     * Deletes the specified item from storage.
     *
     * @param  integer $id
     * @return json
     */
    public function delete($id)
    {
        $this->model->delete($id);

        return $this->toJson(null, 204);
    }

    /**
     * Returns a listing of items.
     *
     * @return json
     */
    public function index()
    {
        $items = $this->model->all();

        return $this->toJson($items);
    }

    /**
     * Shows the specified item.
     *
     * @return json
     */
    public function show($id)
    {
        $item = $this->model->find($id);

        return $this->toJson($item);
    }

    /**
     * Stores the specified item to storage.
     *
     * @return json
     */
    public function store()
    {
        $parameters = $this->request->getParsedBody();

        if (! $this->validator->validate($parameters)) {
            $errors = $this->validator->errors;

            return $this->toJson($errors, 400);
        }

        $id = $this->model->insert($parameters);

        return $this->show($id);
    }

    /**
     * Updates the specified item from storage.
     *
     * @param  integer $id
     * @return json
     */
    public function update($id)
    {
        $parameters = $this->request->getParsedBody();

        if (! $this->validator->validate($parameters)) {
            $errors = $this->validator->errors;

            return $this->toJson($errors, 400);
        }

        $this->model->update($id, $parameters);

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
