<?php

declare(strict_types=1);

namespace PocketShares\Stock\Infrastructure\Doctrine\Entity;

use Doctrine\ORM\Mapping as ORM;
use Money\Money;
use PocketShares\Shared\Infrastructure\Doctrine\Entity\BaseEntity;
use PocketShares\Stock\Infrastructure\Doctrine\Repository\DividendPaymentEntityRepository;

#[ORM\Entity(repositoryClass: DividendPaymentEntityRepository::class)]
#[ORM\Table(name: "dividend_payment")]
class DividendPaymentEntity extends BaseEntity
{
    #[Orm\ManyToOne(targetEntity: StockEntity::class)]
    #[Orm\JoinColumn(name: 'stock_id', referencedColumnName: 'id')]
    private StockEntity $stock;

    #[Orm\Column(name: 'record_date', type: 'date_immutable')]
    private \DateTimeImmutable $recordDate;

    #[ORM\Column(type: 'money_type')]
    private Money $amount;

    public function __construct(StockEntity $stockEntity, \DateTimeImmutable $recordDate, Money $amount)
    {
        $this->stock = $stockEntity;
        $this->recordDate = $recordDate;
        $this->amount = $amount;
    }

    public function getStock(): StockEntity
    {
        return $this->stock;
    }

    public function getRecordDate(): \DateTimeImmutable
    {
        return $this->recordDate;
    }

    public function getAmount(): Money
    {
        return $this->amount;
    }
}