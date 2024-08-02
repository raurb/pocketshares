<?php

declare(strict_types=1);

namespace PocketShares\System\Infrastructure\Doctrine\Entity;

use Doctrine\ORM\Mapping as ORM;
use Money\Money;
use PocketShares\Shared\Infrastructure\Doctrine\Entity\BaseEntity;
use PocketShares\Stock\Infrastructure\Doctrine\Entity\StockEntity;
use PocketShares\System\Infrastructure\Doctrine\Repository\SystemDividendPaymentEntityRepository;

#[ORM\Entity(repositoryClass: SystemDividendPaymentEntityRepository::class)]
#[ORM\Table(name: "system_dividend_payment")]
class SystemDividendPaymentEntity extends BaseEntity
{
    #[Orm\ManyToOne(targetEntity: StockEntity::class)]
    #[Orm\JoinColumn(name: 'stock_id', referencedColumnName: 'id')]
    private StockEntity $stock;

    #[Orm\Column(name: 'payout_date', type: 'date_immutable')]
    private \DateTimeImmutable $payoutDate;

    #[ORM\Column(type: 'money_type')]
    private Money $amount;

    public function __construct(StockEntity $stockEntity, \DateTimeImmutable $payoutDate, Money $amount)
    {
        $this->stock = $stockEntity;
        $this->payoutDate = $payoutDate;
        $this->amount = $amount;
    }

    public function getStock(): StockEntity
    {
        return $this->stock;
    }

    public function getPayoutDate(): \DateTimeImmutable
    {
        return $this->payoutDate;
    }

    public function getAmount(): Money
    {
        return $this->amount;
    }
}