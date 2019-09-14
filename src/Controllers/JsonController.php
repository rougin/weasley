<?php

namespace Rougin\Weasley\Controllers;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * JSON Controller
 *
 * @package Weasley
 * @author  Rougin Gutib <rougingutib@gmail.com>
 */
class JsonController extends BaseController
{
    /**
     * @var string
     */
    protected $model = '';

    /**
     * @var \Illuminate\Database\Eloquent\Model
     */
    protected $eloquent;

    /**
     * @var string|null
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
     * Initializes the controller instance.
     *
     * @param \Psr\Http\Message\ServerRequestInterface $request
     * @param \Psr\Http\Message\ResponseInterface      $response
     */
    public function __construct(ServerRequestInterface $request, ResponseInterface $response)
    {
        $this->check('validator');

        $this->validation = new $this->validator;

        $this->check('model');

        $this->eloquent = new $this->model;

        parent::__construct($request, $response);
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
        if (class_exists('Illuminate\Pagination\LengthAwarePaginator') === true) {
            list($columns, $current, $filter) = $this->pagination();

            $items = $this->eloquent->paginate($filter, $columns, 'page', $current);
        }

        isset($items) || $items = $this->eloquent->all();

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

            $result = $item->toArray();
        } catch (\RuntimeException $error) {
            $code = 404;

            $result = 'Specified item not found';
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
        list($result, $code) = $this->save();

        $array = is_array($result) === true;

        ! $array && $result = $result->toArray();

        return $this->json($result, $code);
    }

    /**
     * Updates the specified item from storage.
     *
     * @param  integer $id
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function update($id)
    {
        $model = 'Illuminate\Database\Eloquent\Model';

        list($result, $code) = $this->save($id);

        is_a($result, $model) && $result = null;

        return $this->json($result, (integer) $code);
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
        $names = array('model' => 'Eloquent model ($model)');

        $names['validator'] = 'Validator ($validator)';

        if ($this->{$name} === '' || $this->{$name} === null) {
            $message = ' must be defined in the controller';

            $message = $names[$name] . $message;

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

        $defaults = array('limit' => null, 'page' => null);

        $defaults['columns'] = '*';

        foreach ($defaults as $key => $value) {
            $exists = ! isset($query[$key]);

            $exists && $query[$key] = $value;
        }

        $page = $query['page'];

        $limit = $query['limit'];

        $columns = explode(',', $query['columns']);

        return array($columns, $page, $limit);
    }

    /**
     * Creates/updates the data to storage.
     *
     * @param  integer|null $id
     * @return array
     */
    protected function save($id = null)
    {
        $parsed = (array) $this->request->getParsedBody();

        if ($this->validation->validate($parsed)) {
            if (is_null($id) === false) {
                $item = $this->eloquent->find($id);

                $item->update((array) $parsed);

                return array($item, (integer) 204);
            }

            $item = $this->eloquent->create($parsed);

            return array($item, (integer) 201);
        }

        return array($this->validation->errors, 400);
    }
}
