<?php

declare(strict_types=1);

namespace PocketShares\StockExchange\Stock;

class StockService
{
    public function __construct(private readonly StockRepository $stockRepository)
    {
    }

    public function load(int $stockId): Stock
    {
        $stock = $this->stockRepository->find($stockId);
        if($stock === null) {
            throw new \InvalidArgumentException(sprintf('Stock with given id "%d" does not exist.', $stockId));
        }

        return $stock;
    }

    public function loadDto(int $id): StockDto
    {
        $stock = $this->load($id);
        return StockDto::from($stock);
    }

    public function add(StockDto $stockDto): StockDto
    {
        $stock = new Stock(
            name: $stockDto->name,
            ticker: $stockDto->ticker,
            symbol: $stockDto->symbol,
        );
        $this->stockRepository->save($stock);

        return $this->loadDto($stock->getId());
    }
}