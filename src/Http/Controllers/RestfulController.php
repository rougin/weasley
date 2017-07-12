<?php

namespace Rougin\Weasley\Http\Controllers;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use Rougin\Weasley\Validators\AbstractValidator;

/**
 * RESTful Controller
 *
 * @package Weasley
 * @author  Rougin Royce Gutib <rougingutib@gmail.com>
 */
class RestfulController extends BaseController
{
    /**
     * @var \Illuminate\Database\Eloquent\Model
     */
    protected $eloquent;

    /**
     * @var string
     */
    protected $model = '';

    /**
     * @var \Rougin\Weasley\Validators\AbstractValidator
     */
    protected $validation;

    /**
     * @var string
     */
    protected $validator = '';

    /**
     * @param \Psr\Http\Message\ServerRequestInterface $request
     * @param \Psr\Http\Message\ResponseInterface      $response
     */
    public function __construct(ServerRequestInterface $request, ResponseInterface $response)
    {
        parent::__construct($request, $response);

        $this->check('model');

        $this->eloquent = new $this->model;

        $this->check('validator');

        $this->validation = new $this->validator;
    }

    /**
     * Deletes the specified item from storage.
     *
     * @param  integer $id
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function delete($id)
    {
        $item = $this->eloquent->find($id);

        $item->delete();

        return $this->json(null, 204);
    }

    /**
     * Returns a listing of items.
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function index()
    {
        $exists = class_exists('Illuminate\Pagination\LengthAwarePaginator');

        $items = $exists ? $this->eloquent->paginate() : $this->eloquent->all();

        return $this->json($items->toArray());
    }

    /**
     * Shows the specified item.
     *
     * @param  integer $id
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function show($id)
    {
        list($code, $result) = array(200, array());

        try {
            $item = $this->eloquent->findOrFail($id);

            list($code, $result) = array(200, $item->toArray());
        } catch (ModelNotFoundException $e) {
            $message = 'Specified item not found';

            list($code, $result) = array(404, $message);
        }

        return $this->json($result, $code);
    }

    /**
     * Stores the specified item to storage.
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function store()
    {
        list($item, $code) = $this->save($this->eloquent, $this->validation);

        return $this->json($item, $code);
    }

    /**
     * Updates the specified item from storage.
     *
     * @param  integer $id
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function update($id)
    {
        list($item, $code) = $this->save($this->eloquent, $this->validation, $id);

        return $this->json($item, $code);
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

        if (! $validator->validate((array) $parameters)) {
            $errors = $validator->errors;

            return array($errors, 400);
        }

        if (is_null($id)) {
            $item = $model->create($parameters);

            return array($item->toArray(), 201);
        }

        $model->find($id)->update($parameters);

        return array(null, 204);
    }
}
