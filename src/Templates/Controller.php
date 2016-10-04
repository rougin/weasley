<?php

namespace {{ application.name }}\{{ namespaces.controllers }};

/**
 * {{ plural | title | replace({ '_': ' ' }) }} Controller
 *
 * @package {{ application.name }}
 * @author  {{ author.name }} <{{ author.email }}>
 */
class {{ pluralTitle }}Controller extends BaseController
{
    /**
     * Displays a page for creating a new item.
     * 
     * @return view
     */
    public function create()
    {
        {{ repository.dropdowns | raw }}return view('{{ plural }}/create'{{ repository.compacts.create | raw }});
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

        $message = '{{ singular | capitalize | replace({ '_': ' ' }) }} deleted successfully!';

        return redirect('{{ plural }}', compact('message'));
    }

    /**
     * Displays a page for updating the selected item.
     * 
     * @return view
     */
    public function edit($id)
    {
        {{ repository.dropdowns | raw }}$item = $this->{{ repository.name }}->find($id);

        return view('{{ plural }}/edit', compact('item'{{ repository.compacts.edit | raw }}));
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
        $parameters = request()->getParsedBody();{{ parameters | raw }}

        validate('{{ application.name }}\{{ namespaces.validators }}\{{ singularTitle }}Validator', $parameters);

        $item = $this->{{ repository.name }}->create($parameters);

        $message = '{{ singular | capitalize | replace({ '_': ' ' }) }} created successfully!';

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
        $parameters = request()->getParsedBody();{{ parameters | raw }}

        validate('{{ application.name }}\{{ namespaces.validators }}\{{ singularTitle }}Validator', $parameters);

        $this->{{ repository.name }}->update($id, $parameters);

        $message = '{{ singular | capitalize | replace({ '_': ' ' }) }} updated successfully!';

        return redirect('{{ plural }}', compact('message'));
    }
}
