<?php

declare(strict_types=1);

namespace PocketShares\Portfolio\Infrastructure\Doctrine\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use PocketShares\Portfolio\Domain\TransactionType;
use PocketShares\Shared\Domain\NumberOfShares;
use PocketShares\Shared\Infrastructure\Doctrine\Entity\BaseEntity;
use PocketShares\Stock\Infrastructure\Doctrine\Entity\StockEntity;

#[Orm\Entity]
#[Orm\Table(name: "portfolio_holding")]
class PortfolioHoldingEntity extends BaseEntity
{
    #[Orm\ManyToOne(targetEntity: PortfolioEntity::class, inversedBy: 'holdings')]
    private PortfolioEntity $portfolio;

    #[Orm\ManyToOne(targetEntity: StockEntity::class)]
    private StockEntity $stock;

    #[Orm\Column(name: 'number_of_shares', type: 'number_of_shares_type', precision: NumberOfShares::PRECISION)]
    private NumberOfShares $numberOfShares;

    #[Orm\OneToMany(mappedBy: 'portfolioHolding', targetEntity: PortfolioTransactionEntity::class)]
    private Collection $transactions;

    public function __construct(PortfolioEntity $portfolio, StockEntity $stock, ?NumberOfShares $numberOfShares = null)
    {
        $this->portfolio = $portfolio;
        $this->stock = $stock;
        $this->numberOfShares = $numberOfShares ?? new NumberOfShares(0);
        $this->transactions = new ArrayCollection();
    }

    public function getPortfolio(): PortfolioEntity
    {
        return $this->portfolio;
    }

    public function getStock(): StockEntity
    {
        return $this->stock;
    }

    public function getNumberOfShares(): NumberOfShares
    {
        return $this->numberOfShares;
    }

    public function getTransactions(): Collection
    {
        return $this->transactions;
    }

    public function setNumberOfShares(NumberOfShares $numberOfShares): void
    {
        $this->numberOfShares = $numberOfShares;
    }

    public function addShares(NumberOfShares $numberOfShares): void
    {
        $this->numberOfShares = new NumberOfShares($this->numberOfShares->getNumberOfShares() + $numberOfShares->getNumberOfShares());
    }

    public function reduceShares(NumberOfShares $numberOfShares): void
    {
        if ($this->numberOfShares->getNumberOfShares() > $numberOfShares->getNumberOfShares()) {
            $this->numberOfShares = new NumberOfShares($this->numberOfShares->getNumberOfShares() - $numberOfShares->getNumberOfShares());
        }
    }

    public function registerTransaction(PortfolioTransactionEntity $transaction): void
    {
        match ($transaction->getTransactionType()) {
            TransactionType::TYPE_BUY => $this->numberOfShares = new NumberOfShares($this->numberOfShares->getNumberOfShares() + $transaction->getNumberOfShares()->getNumberOfShares()),
            TransactionType::TYPE_SELL => $this->numberOfShares = new NumberOfShares($this->numberOfShares->getNumberOfShares() - $transaction->getNumberOfShares()->getNumberOfShares()),
            TransactionType::TYPE_CLOSE_POSITION => $this->numberOfShares = new NumberOfShares(0),
        };
    }
}