<?php

declare(strict_types=1);

namespace PocketShares\Portfolio;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Gedmo\Timestampable\Traits\Timestampable;

//#[Entity]
class Portfolio
{
    use Timestampable;

    public function __construct(
        #[Column(type: 'string')] private string $name,
        )
    {
    }
}