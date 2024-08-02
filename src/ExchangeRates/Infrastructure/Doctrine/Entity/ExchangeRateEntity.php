<?php

declare(strict_types=1);

namespace PocketShares\ExchangeRates\Infrastructure\Doctrine\Entity;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Table;
use Money\Currency;
use Money\Money;
use PocketShares\ExchangeRates\Infrastructure\Doctrine\Repository\ExchangeRateEntityRepository;
use PocketShares\Shared\Infrastructure\Doctrine\Entity\BaseEntity;

/**
 * @todo pozniej sprawdzic cache
 * @see https://www.doctrine-project.org/projects/doctrine-orm/en/2.17/reference/second-level-cache.html
 */
#[Entity(repositoryClass: ExchangeRateEntityRepository::class)]
#[Table(name: "exchange_rate")]
class ExchangeRateEntity extends BaseEntity
{
    #[Column(type: 'currency_type', length: 3)]
    private Currency $fromCurrency;

    #[Column(type: 'currency_type', length: 3)]
    private Currency $toCurrency;

    #[Column(name: 'date', type: 'date_immutable')]
    private \DateTimeImmutable $date;

    #[Column(type: 'money_type')]
    private Money $rate;

    public function __construct(Currency $fromCurrency, Currency $toCurrency, \DateTimeImmutable $date, Money $rate)
    {
        $this->fromCurrency = $fromCurrency;
        $this->toCurrency = $toCurrency;
        $this->date = $date;
        $this->rate = $rate;
    }

    public function getFromCurrency(): Currency
    {
        return $this->fromCurrency;
    }

    public function getToCurrency(): Currency
    {
        return $this->toCurrency;
    }

    public function getDate(): \DateTimeImmutable
    {
        return $this->date;
    }

    public function getRate(): Money
    {
        return $this->rate;
    }
}