<?php

namespace Rougin\Weasley\Routes;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * JSON Route
 *
 * @package Weasley
 * @author  Rougin Gutib <rougingutib@gmail.com>
 */
class JsonRoute extends HttpRoute
{
    const ELOQUENT = 'Illuminate\Database\Eloquent\Model';

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
    protected $mutator = 'Rougin\Weasley\Mutators\RestMutator';

    /**
     * @deprecated since ~0.7, use "$mutator" instead.
     *
     * @var string|null
     */
    protected $transformer = null;

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

        /** @var \Rougin\Weasley\Validators\AbstractValidator */
        $validation = new $this->validator;

        $this->validation = $validation;

        $this->check('model');

        /** @var \Illuminate\Database\Eloquent\Model */
        $model = new $this->model;

        $this->eloquent = $model;

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
        $pagination = 'Illuminate\Pagination\LengthAwarePaginator';

        $items = null;

        if (class_exists($pagination))
        {
            $pagination = $this->pagination();

            /** @var string[] */
            $columns = $pagination['columns'];

            /** @var integer */
            $current = $pagination['page'];

            /** @var integer */
            $filter = $pagination['limit'];

            $items = $this->eloquent->paginate($filter, $columns, 'page', $current);
        }

        $items = $items ? $items : $this->eloquent->all();

        /** @var \Rougin\Weasley\Contract\Mutator */
        $mutator = new $this->mutator;

        if ($this->transformer)
        {
            /** @var \Rougin\Weasley\Transformer\TransformerInterface */
            $mutator = new $this->transformer;
        }

        return $this->json($mutator->mutate($items));
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

        try
        {
            $item = $this->eloquent->findOrFail($id);

            $result = $item->toArray();
        }
        catch (\RuntimeException $error)
        {
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
        $response = $this->save();

        /** @var object|array<string, string[]> */
        $result = $response[0];

        /** @var integer */
        $code = $response[1];

        if (is_object($result) && is_a($result, self::ELOQUENT))
        {
            /** @var \Illuminate\Database\Eloquent\Model */
            $model = $result;

            $result = $model->toArray();
        }

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
        $response = $this->save($id);

        /** @var object|array<string, string[]> */
        $result = $response[0];

        /** @var integer */
        $code = $response[1];

        if (is_object($result) && is_a($result, self::ELOQUENT))
        {
            $result = null;
        }

        return $this->json($result, $code);
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

        if ($this->{$name} === '' || $this->{$name} === null)
        {
            $message = ' must be defined in the controller';

            $message = $names[$name] . $message;

            throw new \UnexpectedValueException($message);
        }
    }

    /**
     * Define the variables needed for pagination, if available.
     *
     * @return array<string, integer|string[]|string>
     */
    protected function pagination()
    {
        $query = $this->request->getQueryParams();

        $defaults = array('limit' => null, 'page' => null);

        $defaults['columns'] = '*';

        foreach ($defaults as $key => $value)
        {
            $exists = ! isset($query[$key]);

            $exists && $query[$key] = $value;
        }

        $result = array('page' => $query['page']);

        $result['limit'] = $query['limit'];

        $columns = explode(',', $query['columns']);

        $result['columns'] = $columns;

        return (array) $result;
    }

    /**
     * Creates/updates the data to storage.
     *
     * @param  integer|null $id
     * @return array<integer, mixed|integer>
     */
    protected function save($id = null)
    {
        $parsed = (array) $this->request->getParsedBody();

        if ($this->validation->validate($parsed))
        {
            if (is_null($id) === false)
            {
                $item = $this->eloquent->find($id);

                $item->update((array) $parsed);

                return array($item, (int) 204);
            }

            $item = $this->eloquent->create($parsed);

            return array($item, (int) 201);
        }

        return array($this->validation->errors, 400);
    }
}
