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
class RestfulController extends BaseController
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
     * @var \Rougin\Weasley\Validators\AbstractValidator|string
     */
    protected $validator;

    /**
     * @param \Psr\Http\Message\ServerRequestInterface $request
     * @param \Psr\Http\Message\ResponseInterface      $response
     */
    public function __construct(ServerRequestInterface $request, ResponseInterface $response)
    {
        parent::__construct($response);

        $this->request = $request;

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

        $this->validator = new $this->validator;
    }

    /**
     * Deletes the specified item from storage.
     *
     * @param  integer $id
     * @return json
     */
    public function delete($id)
    {
        $item = $this->model->find($id);

        $item->delete();

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
        $parameters = (is_null($parameters)) ? array() : $parameters;

        if (! $this->validator->validate($parameters)) {
            $errors = $this->validator->errors;

            return $this->toJson($errors, 400);
        }

        return $this->show($this->model->create($parameters));
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
        $parameters = (is_null($parameters)) ? array() : $parameters;

        if (! $this->validator->validate($parameters)) {
            $errors = $this->validator->errors;

            return $this->toJson($errors, 400);
        }

        $this->model->find($id)->update($parameters);

        return $this->toJson(null, 204);
    }
}
