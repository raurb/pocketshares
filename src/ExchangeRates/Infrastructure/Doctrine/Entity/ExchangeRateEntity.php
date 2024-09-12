<?php

declare(strict_types=1);

namespace PocketShares\ExchangeRates\Infrastructure\Doctrine\Entity;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Table;
use Money\Currency;
use PocketShares\ExchangeRates\Infrastructure\Doctrine\Repository\ExchangeRateEntityRepository;
use PocketShares\Shared\Infrastructure\Doctrine\Entity\BaseEntity;

/**
 * @todo pozniej sprawdzic cache
 * @todo dorobic stawki withholding_tax
 * @see https://www.doctrine-project.org/projects/doctrine-orm/en/2.17/reference/second-level-cache.html
 */
#[Entity(repositoryClass: ExchangeRateEntityRepository::class)]
#[Table(name: "exchange_rate")]
class ExchangeRateEntity extends BaseEntity
{
    #[Column(type: 'currency_type', length: 3)]
    private Currency $currencyFrom;

    #[Column(type: 'currency_type', length: 3)]
    private Currency $currencyTo;

    #[Column(name: 'date', type: 'date_immutable')]
    private \DateTimeImmutable $date;

    #[Column(type: 'decimal', precision: 9, scale: 5)]
    private float $rate;

    public function __construct(Currency $fromCurrency, Currency $toCurrency, \DateTimeImmutable $date, float $rate)
    {
        $this->currencyFrom = $fromCurrency;
        $this->currencyTo = $toCurrency;
        $this->date = $date;
        $this->rate = $rate;
    }

    public function getCurrencyFrom(): Currency
    {
        return $this->currencyFrom;
    }

    public function getCurrencyTo(): Currency
    {
        return $this->currencyTo;
    }

    public function getDate(): \DateTimeImmutable
    {
        return $this->date;
    }

    public function getRate(): float
    {
        return $this->rate;
    }
}