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

        $this->checkProperty('model');

        $this->model = new $this->model;

        $this->checkProperty('validator');

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
        return $this->save($this->request, $this->model);
    }

    /**
     * Updates the specified item from storage.
     *
     * @param  integer $id
     * @return json
     */
    public function update($id)
    {
        return $this->save($this->request, $this->model, $id);
    }
}
