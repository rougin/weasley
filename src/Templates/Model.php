<?php

namespace {{ application.name }}\{{ namespaces.models }};

use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Table;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;{{ foreignClasses }}

/**
 * {{ singular | title | replace({'_': ' '}) }} Model
 *
 * @package {{ application.name }}
 * @author  {{ author.name }} <{{ author.email }}>
 * 
 * @Entity(repositoryClass="{{ application.name }}\Repositories\{{ plural | title }}Repository")
 * @Table(name="{{ singular }}")
 */
class {{ singularTitle }}
{
    {{ columns | raw }}

    {{ methods | raw }}
}
