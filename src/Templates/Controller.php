<?php

namespace {{ application.name }}\{{ namespaces.controllers }};

use {{ application.name }}\{{ namespaces.validators }}\{{ singular | title }}Validator;
use {{ application.name }}\{{ namespaces.repositories }}\{{ singular | title }}Repository;{{ repository.namespaces }}

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
    protected ${{ repository.name }};{{ repository.variables }}

    /**
     * @param \{{ application.name }}\Repositories\{{ singular | title }}Repository ${{ repository.name }}{{ repository.parameters }}
     */
    public function __construct({{ singular | title }}Repository ${{ repository.name }}{{ repository.constructors }})
    {
        $this->{{ repository.name }} = ${{ repository.name }};{{ repository.definitions | raw }}
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
        $this->{{ repository.name }}->delete($id);

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
        $item = $this->{{ repository.name }}->find($id);

        return view('{{ plural }}/edit', compact('item'));
    }

    /**
     * Returns a listing of items.
     * 
     * @return view
     */
    public function index()
    {
        list($items, $links) = paginate($this->{{ repository.name }}->findAll());

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

        ${{ singular }} = $this->{{ repository.name }}->create($parameters);

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

        $this->{{ repository.name }}->update($id, $parameters);

        $message = '{{ singular | title }} updated successfully!';

        return redirect('{{ plural }}', compact('message'));
    }
}
