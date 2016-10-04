<?php

namespace {{ application.name }}\{{ namespaces.components }};

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

/**
 * Doctrine Component
 *
 * @package {{ application.name }}
 * @author  {{ author.name }} <{{ author.email }}>
 */
class DoctrineComponent extends \Rougin\Slytherin\Component\AbstractComponent
{
    /**
     * Sets the component and add it to the container of your choice.
     *
     * @param  \Interop\Container\ContainerInterface $container
     * @return void
     */
    public function set(\Interop\Container\ContainerInterface &$container)
    {
        $config = Setup::createAnnotationMetadataConfiguration(
            config('doctrine.model_paths'),
            config('doctrine.developer_mode')
        );

        $config->setProxyDir(config('doctrine.proxy_path'));
        $config->setAutoGenerateProxyClasses(config('doctrine.developer_mode'));

        $entityManager = EntityManager::create(config('database.mysql'), $config);

        if ($container instanceof \Rougin\Slytherin\IoC\Vanilla\Container) {
            $container->add('Doctrine\ORM\EntityManager', $entityManager);
        }
    }
}
