<?php

declare(strict_types=1);

namespace PocketShares\Portfolio\Infrastructure\Doctrine\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use Money\Currency;
use Money\Money;
use PocketShares\Portfolio\Infrastructure\Doctrine\Repository\PortfolioEntityRepository;
use PocketShares\Shared\Infrastructure\Doctrine\Entity\BaseEntity;
use PocketShares\System\Infrastructure\Doctrine\Entity\SystemDividendPaymentEntity;

#[ORM\Entity(repositoryClass: PortfolioEntityRepository::class)]
#[ORM\Table(name: "portfolio")]
class PortfolioEntity extends BaseEntity
{
    use TimestampableEntity;

    #[ORM\Column(type: 'string', length: 50)]
    private string $name;

    #[ORM\Column(type: 'money_type')]
    private Money $value;

    #[ORM\OneToMany(mappedBy: 'portfolio', targetEntity: PortfolioHoldingEntity::class, cascade: ['persist', 'remove'])]
    private Collection $holdings;

    #[ORM\OneToMany(mappedBy: 'portfolio', targetEntity: PortfolioTransactionEntity::class, cascade: ['persist', 'remove'])]
    private Collection $transactions;

    #[ORM\OneToMany(mappedBy: 'portfolio', targetEntity: PortfolioDividendPaymentEntity::class, cascade: ['persist', 'remove'])]
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

    public function addDividendPayment(PortfolioDividendPaymentEntity $dividendPaymentEntity): void
    {
        if ($this->dividendPayments->contains($dividendPaymentEntity)) {
            return;
        }

        $this->dividendPayments->add($dividendPaymentEntity);
    }
}