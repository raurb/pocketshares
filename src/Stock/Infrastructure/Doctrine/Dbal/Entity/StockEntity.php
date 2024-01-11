<?php

declare(strict_types=1);

namespace PocketShares\Stock\Infrastructure\Doctrine\Dbal\Entity;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Index;
use Doctrine\ORM\Mapping\Table;
use PocketShares\Shared\Infrastructure\Doctrine\Entity\BaseEntity;

/**
 * @todo pozniej sprawdzic cache
 * @see https://www.doctrine-project.org/projects/doctrine-orm/en/2.17/reference/second-level-cache.html
 */
#[Entity]
#[Table(name: "stock")]
#[Index(columns: ['ticker'], name: 'ticker_idx')]
class StockEntity extends BaseEntity
{
    #[Column(type: 'string', length: 100)]
    private string $name;

    #[Column(type: 'string', length: 5)]
    private string $ticker;

    #[Column(type: 'market_symbol_enum_type', length: 10)]
    private string $marketSymbol;

    #[Column(type: 'string', length: 3)]
    private string $currency;

    public function __construct(
        string $name,
        string $ticker,
        string $marketSymbol,
        string $currency
    ) {
        $this->name = $name;
        $this->ticker = $ticker;
        $this->marketSymbol = $marketSymbol;
        $this->currency = $currency;
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

    public function getMarketSymbol(): string
    {
        return $this->marketSymbol;
    }

    public function setMarketSymbol(string $marketSymbol): void
    {
        $this->marketSymbol = $marketSymbol;
    }

    public function getCurrency(): string
    {
        return $this->currency;
    }

    public function setCurrency(string $currency): void
    {
        $this->currency = $currency;
    }
}