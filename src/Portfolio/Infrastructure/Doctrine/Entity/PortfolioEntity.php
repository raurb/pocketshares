<?php

declare(strict_types=1);

namespace PocketShares\Portfolio\Infrastructure\Doctrine\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\InverseJoinColumn;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\JoinTable;
use Doctrine\ORM\Mapping\ManyToMany;
use Doctrine\ORM\Mapping\Table;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Money\Currency;
use Money\Money;
use PocketShares\Portfolio\Infrastructure\Doctrine\Repository\PortfolioEntityRepository;
use PocketShares\Shared\Infrastructure\Doctrine\Entity\BaseEntity;
use PocketShares\System\Infrastructure\Doctrine\Entity\SystemDividendPaymentEntity;

#[Entity(repositoryClass: PortfolioEntityRepository::class)]
#[Table(name: "portfolio")]
class PortfolioEntity extends BaseEntity
{
    use TimestampableEntity;

    #[Column(type: 'string', length: 50)]
    private string $name;

    #[Column(type: 'money_type')]
    private Money $value;

    #[ORM\OneToMany(mappedBy: 'portfolio', targetEntity: PortfolioHoldingEntity::class, cascade: ['persist', 'remove'])]
    private Collection $holdings;

    #[ORM\OneToMany(mappedBy: 'portfolio', targetEntity: PortfolioTransactionEntity::class, cascade: ['persist', 'remove'])]
    private Collection $transactions;

    #[JoinTable(name: 'portfolio_dividend_payment')]
    #[JoinColumn(name: 'portfolio_id', referencedColumnName: 'id')]
    #[InverseJoinColumn(name: 'dividend_id', referencedColumnName: 'id')]
    #[ManyToMany(targetEntity: SystemDividendPaymentEntity::class)]
    private Collection $dividendPayments;

    public function __construct(string $name, string $currency)
    {
        $this->name = $name;
        $this->value = new Money(0, new Currency($currency));
        $this->holdings = new ArrayCollection();
        $this->transactions = new ArrayCollection();
        $this->dividendPayments = new ArrayCollection();
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

    public function getHoldings(): Collection
    {
        return $this->holdings;
    }

    public function getValue(): Money
    {
        return $this->value;
    }

    public function getTransactions(): Collection
    {
        return $this->transactions;
    }

    public function getHoldingByTicker(string $ticker): ?PortfolioHoldingEntity
    {
        $ticker = \strtoupper($ticker);
        /** @var PortfolioHoldingEntity $possessedHolding */
        foreach ($this->holdings as $possessedHolding) {
            if ($possessedHolding->getStock()->getTicker() === $ticker) {
                return $possessedHolding;
            }
        }

        return null;
    }

    public function addDividendPayment(SystemDividendPaymentEntity $dividendPaymentEntity): void
    {
        if ($this->dividendPayments->contains($dividendPaymentEntity)) {
            return;
        }

        $this->dividendPayments->add($dividendPaymentEntity);
    }
}