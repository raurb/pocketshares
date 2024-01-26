<?php

declare(strict_types=1);

namespace PocketShares\Portfolio\Infrastructure\Repository\RegisterTransaction\Strategy;

use PocketShares\Portfolio\Domain\Transaction;
use PocketShares\Portfolio\Domain\TransactionType;
use PocketShares\Portfolio\Infrastructure\Doctrine\Entity\PortfolioEntity;

interface RegisterTransactionStrategyInterface
{
    public function isSupported(TransactionType $transactionType): bool;
    public function handle(PortfolioEntity $portfolioEntity, Transaction $newTransaction): PortfolioEntity;
}