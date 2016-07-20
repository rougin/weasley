<?php

namespace {{ application }}\{{ namespaces.models }};

use DateTime;

use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Table;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;

/**
 * @Entity(repositoryClass="{{ application }}\Repositories\{{ plural | title }}Repository")
 * @Table(name="user")
 */
class {{ singular | title }}
{
    {{ columns | raw }}

    {{ methods | raw }}
}
