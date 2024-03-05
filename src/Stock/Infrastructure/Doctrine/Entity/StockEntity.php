<?php

declare(strict_types=1);

namespace PocketShares\Stock\Infrastructure\Doctrine\Entity;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Index;
use Doctrine\ORM\Mapping\Table;
use Money\Currency;
use PocketShares\Shared\Infrastructure\Doctrine\Entity\BaseEntity;
use PocketShares\Stock\Domain\MarketSymbol;
use PocketShares\Stock\Infrastructure\Doctrine\Repository\StockEntityRepository;

/**
 * @todo pozniej sprawdzic cache
 * @see https://www.doctrine-project.org/projects/doctrine-orm/en/2.17/reference/second-level-cache.html
 */
#[Entity(repositoryClass: StockEntityRepository::class)]
#[Table(name: "stock")]
#[Index(columns: ['ticker'], name: 'ticker_idx')]
class StockEntity extends BaseEntity
{
    #[Column(type: 'string', length: 100)]
    private string $name;

    #[Column(type: 'string', length: 5)]
    private string $ticker;

    #[Column(type: 'market_symbol', length: 10)]
    private MarketSymbol $marketSymbol;

    #[Column(type: 'currency_type', length: 3)]
    private Currency $currency;

    public function __construct(
        string $name,
        string $ticker,
        MarketSymbol $marketSymbol,
        Currency $currency
    ) {
        $this->name = $name;
        $this->ticker = \strtoupper($ticker);
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

    public function getMarketSymbol(): MarketSymbol
    {
        return $this->marketSymbol;
    }

    public function setMarketSymbol(MarketSymbol $marketSymbol): void
    {
        $this->marketSymbol = $marketSymbol;
    }

    public function getCurrency(): Currency
    {
        return $this->currency;
    }

    public function setCurrency(Currency $currency): void
    {
        $this->currency = $currency;
    }
}