<?php

declare(strict_types=1);

namespace PocketShares\Stock;

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

    public function getStocks(?int $offset = null, ?int $limit = null)
    {
        return $this->stockRepository->findAll();
    }

    public function loadDto(int $id): StockDto
    {
        return StockDtoFactory::createFromEntity($this->load($id));
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