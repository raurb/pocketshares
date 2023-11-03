<?php

declare(strict_types=1);

namespace PocketShares\StockExchange\Stock;

use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Column;
use PocketShares\Common\BaseEntity;
use PocketShares\StockExchange\Symbol;

#[Entity]
class Stock extends BaseEntity
{
    public function __construct(
        #[Column(type: 'string')]
        private string $name,
        #[Column(type: 'string')]
        private string $ticker,
        #[Column(type: 'string', enumType: Symbol::class)]
        private Symbol $symbol
    )
    {
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function getTicker(): string
    {
        return $this->ticker;
    }

    public function setTicker(string $ticker): self
    {
        $this->ticker = $ticker;
        return $this;
    }

    public function getSymbol(): Symbol
    {
        return $this->symbol;
    }

    public function setSymbol(Symbol $symbol): self
    {
        $this->symbol = $symbol;
        return $this;
    }
}