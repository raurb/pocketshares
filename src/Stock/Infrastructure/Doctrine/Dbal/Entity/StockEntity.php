<?php

declare(strict_types=1);

namespace PocketShares\Stock\Infrastructure\Doctrine\Dbal\Entity;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Table;
use Money\Currency;

#[Entity]
#[Table(name: "stock")]
class StockEntity
{
    #[Id]
    #[Column(type: 'integer')]
    #[GeneratedValue]
    private ?int $id = null;

    #[Column(type: 'string')]
    private string $name;

    #[Column(type: 'string')]
    private string $ticker;

    #[Column(type: 'market_symbol_enum_type')]
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

    public function getId(): ?int
    {
        return $this->id;
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