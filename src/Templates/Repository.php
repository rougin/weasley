<?php

namespace {{ application.name }}\{{ namespaces.repositories }};

use Doctrine\ORM\EntityRepository;

use {{ application.name }}\{{ namespaces.models }}\{{ singular | title }};{{ foreignClasses }}

/**
 * {{ singular | title }} Repository
 *
 * @package {{ application.name }}
 * @author  {{ author.name }} <{{ author.email }}>
 */
class {{ singular | title }}Repository extends EntityRepository
{
    /**
     * Creates a new item.
     * 
     * @param  array $data
     * @return \{{ application.name }}\Models\{{ singular | title }}
     */
    public function create(array $data = [])
    {
        ${{ singular }} = new {{ singular | title }};

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
     * @return \{{ application.name }}\Models\{{ singular | title }}
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
