<?php

namespace {{ application.name }}\{{ namespaces.components }};

/**
 * Repository Component
 *
 * @package {{ application.name }}
 * @author  {{ author.name }} <{{ author.email }}>
 */
class RepositoryComponent extends \Rougin\Slytherin\Component\AbstractComponent
{
    /**
     * Sets the component.
     *
     * @param  \Interop\Container\ContainerInterface $container
     * @return void
     */
    public function set(\Interop\Container\ContainerInterface &$container)
    {
        $entityManager = $container->get('Doctrine\ORM\EntityManager');

        $path  = base('{{ folders.repositories }}/');
        $files = glob($path . '*Repository.php');

        foreach ($files as $item) {
            $entity = str_replace([ $path, 'Repository.php' ], [ '', '' ], $item);
            $model  = '{{ application.name }}\\{{ namespaces.models }}\\' . $entity;
            $name   = '{{ application.name }}\\{{ namespaces.components }}\\' . $entity . 'Repository';

            $metadata = $entityManager->getClassMetadata($model);

            if ($container instanceof \Rougin\Slytherin\IoC\Vanilla\Container) {
                $container->add($name, new $name($entityManager, $metadata));
            }
        }
    }
}
