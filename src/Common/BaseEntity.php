<?php

declare(strict_types=1);

namespace PocketShares\Common;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;

abstract class BaseEntity
{
    #[Id]
    #[Column(type: 'integer')]
    #[GeneratedValue]
    protected int $id;

    public function getId(): int
    {
        return $this->id;
    }
}