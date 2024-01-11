<?php

declare(strict_types=1);

namespace PocketShares\Portfolio\Infrastructure\Doctrine;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Table;
use Gedmo\Timestampable\Traits\Timestampable;
use Money\Money;
use PocketShares\Shared\Infrastructure\Doctrine\Entity\BaseEntity;
use PocketShares\Stock\Infrastructure\Doctrine\Dbal\Entity\StockEntity;

#[Entity]
#[Table(name: "portfolio")]
class PortfolioEntity extends BaseEntity
{
    use Timestampable;

    #[Column(type: 'string', length: 50)]
    private string $name;

    #[ORM\OneToMany(mappedBy: 'id', targetEntity: StockEntity::class)]
    private Collection $holdings;

    #[Column(type: 'money_type')]
    private Money $value;

    public function __construct()
    {
        $this->holdings = new ArrayCollection();
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

    public function setHoldings(Collection $holdings): self
    {
        $this->holdings = $holdings;
        return $this;
    }

    public function getValue(): Money
    {
        return $this->value;
    }

    public function setValue(Money $value): self
    {
        $this->value = $value;
        return $this;
    }
}