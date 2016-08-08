<?php

namespace {{ application.name }}\{{ namespaces.repositories }};

use Doctrine\ORM\EntityRepository;

use {{ application.name }}\{{ namespaces.models }}\{{ singularTitle }};{{ foreignClasses }}

/**
 * {{ singular | title | replace({ '_': ' ' }) }} Repository
 *
 * @package {{ application.name }}
 * @author  {{ author.name }} <{{ author.email }}>
 */
class {{ singularTitle }}Repository extends EntityRepository
{
    /**
     * Creates a new item.
     * 
     * @param  array $data
     * @return \{{ application.name }}\Models\{{ singularTitle }}
     */
    public function create(array $data = [])
    {
        ${{ singular }} = new {{ singularTitle }};

        {{ createColumns | raw }}

        $this->_em->persist(${{ singular }});
        $this->_em->flush();

        return ${{ singular }};
    }

    /**
     * Deletes the selected item.
     * 
     * @param  integer $id
     * @return void
     */
    public function delete($id)
    {
        ${{ singular }} = $this->find($id);

        $this->_em->remove(${{ singular }});
        $this->_em->flush();
    }

    /**
     * Updates the selected item.
     *
     * @param  integer $id
     * @param  array   $data
     * @return \{{ application.name }}\Models\{{ singularTitle }}
     */
    public function update($id, array $data = [])
    {
        ${{ singular }} = $this->find($id);

        {{ updateColumns | raw }}

        $this->_em->persist(${{ singular }});
        $this->_em->flush();

        return ${{ singular }};
    }
}
