<?php

namespace {{ application.name }}\{{ namespaces.models }};

use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Table;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;{{ foreignClasses }}

/**
 * @Entity(repositoryClass="{{ application.name }}\Repositories\{{ plural | title }}Repository")
 * @Table(name="{{ singular }}")
 */
class {{ singular | title }}
{
    {{ columns | raw }}

    {{ methods | raw }}
}
