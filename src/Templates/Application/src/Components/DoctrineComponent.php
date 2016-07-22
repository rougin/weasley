<?php

namespace {{ application.name }}\{{ namespaces.components }};

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

use Rougin\Slytherin\Component\AbstractComponent;

/**
 * Doctrine Component
 *
 * @package {{ application.name }}
 * @author  {{ author.name }} <{{ author.email }}>
 */
class DoctrineComponent extends AbstractComponent
{
    /**
     * Name of the class to be added in the container.
     * 
     * @var string
     */
    protected $className = EntityManager::class;

    /**
     * Returns an instance from the named class.
     * 
     * @return mixed
     */
    public function get()
    {
        $config = Setup::createAnnotationMetadataConfiguration(
            config('doctrine.model_paths'),
            config('doctrine.developer_mode')
        );

        $config->setProxyDir(config('doctrine.proxy_path'));
        $config->setAutoGenerateProxyClasses(config('doctrine.developer_mode'));

        return EntityManager::create(config('database.mysql'), $config);
    }
}