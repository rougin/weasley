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
     * @var string
     */
    protected $transformer = 'Rougin\Weasley\Transformer\ApiTransformer';

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

        list($columns, $current, $filter) = $this->pagination();

        $items = $exists ? $this->eloquent->paginate($filter, $columns, 'page', $current) : $this->eloquent->all();

        $transformer = new $this->transformer;

        return $this->json($transformer->transform($items));
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

        return $this->json($item instanceof Model ? $item->toArray() : $item, $code);
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

        return $this->json($item instanceof Model ? null : $item, $code);
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
     * Define the variables needed for pagination, if available.
     *
     * @return array
     */
    protected function pagination()
    {
        $query = $this->request->getQueryParams();

        $columns = isset($query['columns']) ? explode(',', $query['columns']) : array('*');

        $current = isset($query['page']) ? $query['page'] : null;

        return array($columns, $current, isset($query['limit']) ? $query['limit'] : null);
    }

    /**
     * Creates/updates the data to storage.
     *
     * @param  \Illuminate\Database\Eloquent\Model          $model
     * @param  \Rougin\Weasley\Validators\AbstractValidator $validator
     * @param  integer                                      $id
     * @return array
     */
    protected function save(Model $model, AbstractValidator $validator, $id = null)
    {
        $parsed = $this->request->getParsedBody();

        if (! $validator->validate($parsed)) {
            return array($validator->errors, 400);
        }

        if (is_null($id) === true) {
            $item = $model->create($parsed);

            return array($item, 201);
        }

        $item = $model->find($id);

        $item->update($parsed);

        return array($item, 204);
    }
}
