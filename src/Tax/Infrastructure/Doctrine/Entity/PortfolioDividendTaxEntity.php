<?php

declare(strict_types=1);

namespace PocketShares\Tax\Infrastructure\Doctrine\Entity;

use Doctrine\ORM\Mapping as ORM;
use Money\Currency;
use Money\Money;
use PocketShares\ExchangeRates\Infrastructure\Doctrine\Entity\ExchangeRateEntity;
use PocketShares\Portfolio\Infrastructure\Doctrine\Entity\PortfolioEntity;
use PocketShares\Shared\Infrastructure\Doctrine\Entity\BaseEntity;
use PocketShares\System\Infrastructure\Doctrine\Entity\SystemDividendPaymentEntity;
use PocketShares\Tax\Infrastructure\Doctrine\Repository\PortfolioDividendTaxRepository;

#[ORM\Entity(repositoryClass: PortfolioDividendTaxRepository::class)]
#[ORM\Table(name: "portfolio_dividend_income_tax")]
class PortfolioDividendTaxEntity extends BaseEntity
{
    #[ORM\ManyToOne(targetEntity: PortfolioEntity::class)]
    private PortfolioEntity $portfolio;

    #[ORM\ManyToOne(targetEntity: SystemDividendPaymentEntity::class)]
    private SystemDividendPaymentEntity $systemDividend;

    #[ORM\ManyToOne(targetEntity: ExchangeRateEntity::class)]
    private ExchangeRateEntity $exchangeRate;

    #[ORM\Column(type: 'string', length: 5)]
    private string $stockTicker;

    #[ORM\Column(type: 'money_type')]
    private Money $dividendGrossAmount;

    #[ORM\Column(type: 'currency_type')]
    private Currency $incomeTaxCurrency;

    #[ORM\Column(type: 'money_type')]
    private Money $withholdingTaxAmount;

    #[ORM\Column(name: 'withholding_tax_rate', type: 'decimal', precision: 9, scale: 5)]
    private float $withholdingTaxRate;

    #[ORM\Column(name: 'income_tax_rate', type: 'decimal', precision: 9, scale: 5)]
    private float $incomeTaxRate;

    #[ORM\Column(type: 'money_type')]
    private Money $dividendAmountInTargetCurrencyGross;

    #[ORM\Column(type: 'money_type')]
    private Money $dividendWithholdingTaxInTargetCurrency;

    #[ORM\Column(type: 'money_type')]
    private Money $taxToPayInTargetCurrency;

    #[ORM\Column(type: 'money_type')]
    private Money $taxLeftToPayInTargetCurrency;

    #[ORM\Column(type: 'money_type')]
    private Money $dividendAmountInTargetCurrencyNet;

    public function __construct(
        PortfolioEntity $portfolio,
        SystemDividendPaymentEntity $systemDividend,
        string $stockTicker,
        ExchangeRateEntity $exchangeRate,
        Money $dividendGrossAmount,
        Currency $incomeTaxCurrency,
        Money $withholdingTaxAmount,
        float $withholdingTaxRate,
        float $incomeTaxRate,
        Money $dividendAmountInTargetCurrencyGross,
        Money $dividendWithholdingTaxInTargetCurrency,
        Money $taxToPayInTargetCurrency,
        Money $taxLeftToPayInTargetCurrency,
        Money $dividendAmountInTargetCurrencyNet,
    )
    {
        $this->portfolio = $portfolio;
        $this->systemDividend = $systemDividend;
        $this->stockTicker = $stockTicker;
        $this->exchangeRate = $exchangeRate;
        $this->dividendGrossAmount = $dividendGrossAmount;
        $this->incomeTaxCurrency = $incomeTaxCurrency;
        $this->withholdingTaxAmount = $withholdingTaxAmount;
        $this->withholdingTaxRate = $withholdingTaxRate;
        $this->incomeTaxRate = $incomeTaxRate;
        $this->dividendAmountInTargetCurrencyGross = $dividendAmountInTargetCurrencyGross;
        $this->dividendAmountInTargetCurrencyNet = $dividendAmountInTargetCurrencyNet;
        $this->dividendWithholdingTaxInTargetCurrency = $dividendWithholdingTaxInTargetCurrency;
        $this->taxToPayInTargetCurrency = $taxToPayInTargetCurrency;
        $this->taxLeftToPayInTargetCurrency = $taxLeftToPayInTargetCurrency;
    }

    public function getPortfolio(): PortfolioEntity
    {
        return $this->portfolio;
    }

    public function getSystemDividend(): SystemDividendPaymentEntity
    {
        return $this->systemDividend;
    }

    public function getExchangeRate(): ExchangeRateEntity
    {
        return $this->exchangeRate;
    }

    public function getStockTicker(): string
    {
        return $this->stockTicker;
    }

    public function getDividendGrossAmount(): Money
    {
        return $this->dividendGrossAmount;
    }

    public function getIncomeTaxCurrency(): Currency
    {
        return $this->incomeTaxCurrency;
    }

    public function getWithholdingTaxRate(): float
    {
        return $this->withholdingTaxRate;
    }

    public function getWithholdingTaxAmount(): Money
    {
        return $this->withholdingTaxAmount;
    }

    public function getIncomeTaxRate(): float
    {
        return $this->incomeTaxRate;
    }

    public function getDividendAmountInTargetCurrencyGross(): Money
    {
        return $this->dividendAmountInTargetCurrencyGross;
    }

    public function getDividendWithholdingTaxInTargetCurrency(): Money
    {
        return $this->dividendWithholdingTaxInTargetCurrency;
    }

    public function getTaxToPayInTargetCurrency(): Money
    {
        return $this->taxToPayInTargetCurrency;
    }

    public function getTaxLeftToPayInTargetCurrency(): Money
    {
        return $this->taxLeftToPayInTargetCurrency;
    }

    public function getDividendAmountInTargetCurrencyNet(): Money
    {
        return $this->dividendAmountInTargetCurrencyNet;
    }
}