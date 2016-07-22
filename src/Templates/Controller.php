<?php

namespace {{ application.name }}\{{ namespaces.controllers }};

use {{ application.name }}\{{ namespaces.validators }}\{{ singular | title }}Validator;
use {{ application.name }}\{{ namespaces.repositories }}\{{ singular | title }}Repository;

/**
 * {{ plural | title }} Controller
 *
 * @package {{ application.name }}
 * @author  {{ author.name }} <{{ author.email }}>
 */
class {{ plural | title }}Controller extends BaseController
{
    /**
     * @var \{{ application.name }}\Repositories\{{ singular | title }}Repository
     */
    protected $repository;

    /**
     * @param \{{ application.name }}\Repositories\{{ singular | title }}Repository $repository
     */
    public function __construct({{ singular | title }}Repository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Displays a page for creating a new item.
     * 
     * @return view
     */
    public function create()
    {
        return view('{{ plural }}/create');
    }

    /**
     * Deletes the selected item.
     * 
     * @param  integer $id
     * @return redirect
     */
    public function delete($id)
    {
        $this->repository->delete($id);

        $message = '{{ singular | title }} deleted successfully!';

        return redirect('{{ plural }}', compact('message'));
    }

    /**
     * Displays a page for updating the selected item.
     * 
     * @return view
     */
    public function edit($id)
    {
        $item = $this->repository->find($id);

        return view('{{ plural }}/edit', compact('item'));
    }

    /**
     * Returns a listing of items.
     * 
     * @return view
     */
    public function index()
    {
        list($items, $links) = paginate($this->repository->findAll());

        return view('{{ plural }}/index', compact('items', 'links'));
    }

    /**
     * Stores the new item to the database.
     * 
     * @return redirect
     */
    public function store()
    {
        $parameters = request()->getParsedBody();

        validate({{ singular | title }}Validator::class, $parameters);

        ${{ singular }} = $this->repository->create($parameters);

        $message = '{{ singular | title }} created successfully!';

        return redirect('{{ plural }}', compact('message'));
    }

    /**
     * Updates the selected item.
     * 
     * @param  integer $id
     * @return redirect
     */
    public function update($id)
    {
        $parameters = request()->getParsedBody();

        validate({{ singular | title }}Validator::class, $parameters);

        $this->repository->update($id, $parameters);

        $message = '{{ singular | title }} updated successfully!';

        return redirect('{{ plural }}', compact('message'));
    }
}
