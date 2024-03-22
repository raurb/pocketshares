<?php

declare(strict_types=1);

namespace PocketShares\Portfolio\Infrastructure\Doctrine\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Column;
use Money\Money;
use PocketShares\Portfolio\Domain\TransactionType;
use PocketShares\Shared\Domain\NumberOfShares;
use PocketShares\Shared\Infrastructure\Doctrine\Entity\BaseEntity;

#[Orm\Entity]
#[Orm\Table(name: "portfolio_transaction")]
class PortfolioTransactionEntity extends BaseEntity
{
    #[Orm\ManyToOne(targetEntity: PortfolioEntity::class, inversedBy: 'transactions')]
    private PortfolioEntity $portfolio;

    #[Orm\ManyToOne(targetEntity: PortfolioHoldingEntity::class, inversedBy: 'transactions')]
    #[ORM\JoinColumn(name: 'holding_id', referencedColumnName: 'id', nullable: true)]
    private ?PortfolioHoldingEntity $portfolioHolding;

    #[Column(name: 'stock_ticker', type: 'string', length: 5)]
    private string $stockTicker;

    #[Orm\Column(name: 'number_of_shares', type: 'number_of_shares_type', precision: NumberOfShares::PRECISION)]
    private NumberOfShares $numberOfShares;

    #[Orm\Column(type: 'money_type')]
    private Money $pricePerShare;

    #[Orm\Column(name: 'transaction_date', type: 'date_immutable')]
    private \DateTimeImmutable $transactionDate;

    #[Orm\Column(type: 'transaction_type')]
    private TransactionType $transactionType;

    public function __construct(
        PortfolioEntity $portfolio,
        PortfolioHoldingEntity $portfolioHolding,
        NumberOfShares $numberOfShares,
        Money $value,
        \DateTimeImmutable $transactionDate,
        TransactionType $transactionType,
    ) {
        $this->portfolio = $portfolio;
        $this->portfolioHolding = $portfolioHolding;
        $this->stockTicker = $portfolioHolding->getStock()->getTicker();
        $this->numberOfShares = $numberOfShares;
        $this->pricePerShare = $value;
        $this->transactionDate = $transactionDate;
        $this->transactionType = $transactionType;
    }

    public function getPortfolio(): PortfolioEntity
    {
        return $this->portfolio;
    }

    public function getPortfolioHolding(): ?PortfolioHoldingEntity
    {
        return $this->portfolioHolding;
    }

    public function getStockTicker(): string
    {
        return $this->stockTicker;
    }

    public function setPortfolioHolding(?PortfolioHoldingEntity $portfolioHolding): void
    {
        $this->portfolioHolding = $portfolioHolding;
    }

    public function getNumberOfShares(): NumberOfShares
    {
        return $this->numberOfShares;
    }

    public function getPricePerShare(): Money
    {
        return $this->pricePerShare;
    }

    public function getTransactionDate(): \DateTimeImmutable
    {
        return $this->transactionDate;
    }

    public function getTransactionType(): TransactionType
    {
        return $this->transactionType;
    }
}