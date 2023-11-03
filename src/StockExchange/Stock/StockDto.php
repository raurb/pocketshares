<?php

declare(strict_types=1);

namespace PocketShares\StockExchange\Stock;

use PocketShares\StockExchange\Symbol;

readonly class StockDto
{
    public int $id;
    public string $name;
    public string $ticker;
    public Symbol $symbol;

    public static function from(Stock $stock): self
    {
        $instance = new self();
        $instance->id = $stock->getId();
        $instance->name = $stock->getName();
        $instance->ticker = $stock->getTicker();
        $instance->symbol = $stock->getSymbol();

        return $instance;
    }

    public static function with(string $name, string $ticker, Symbol $symbol): self
    {
        $instance = new self();
        $instance->name = $name;
        $instance->ticker = $ticker;
        $instance->symbol = $symbol;

        return $instance;
    }
}