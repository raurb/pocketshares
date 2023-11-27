<?php

declare(strict_types=1);

namespace PocketShares\Stock;

use PocketShares\StockExchange\Symbol;

class StockDtoFactory
{
    public static function create(string $name, string $ticker, Symbol $symbol, ?int $id = null): StockDto
    {
        return new StockDto(name: $name,ticker: $ticker,symbol: $symbol,id: $id);
    }

    public static function createFromEntity(Stock $stock): StockDto
    {
        return new StockDto(
            name: $stock->getName(),
            ticker: $stock->getTicker(),
            symbol: $stock->getSymbol(),
            id: $stock->getId(),
        );
    }
}