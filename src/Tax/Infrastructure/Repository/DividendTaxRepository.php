<?php

declare(strict_types=1);

namespace PocketShares\Tax\Infrastructure\Repository;

use Doctrine\ORM\EntityManagerInterface;
use PocketShares\ExchangeRates\Infrastructure\Doctrine\Entity\ExchangeRateEntity;
use PocketShares\Portfolio\Infrastructure\Doctrine\Entity\PortfolioEntity;
use PocketShares\System\Infrastructure\Doctrine\Entity\SystemDividendPaymentEntity;
use PocketShares\Tax\Domain\DividendTax;
use PocketShares\Tax\Domain\Repository\DividendTaxRepositoryInterface;
use PocketShares\Tax\Infrastructure\Doctrine\Entity\PortfolioDividendTaxEntity;

class DividendTaxRepository implements DividendTaxRepositoryInterface
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
    )
    {
    }

    public function store(DividendTax $dividendTax): void
    {
        $entity = new PortfolioDividendTaxEntity(
            portfolio: $this->entityManager->getReference(PortfolioEntity::class, $dividendTax->portfolioId),
            systemDividend: $this->entityManager->getReference(SystemDividendPaymentEntity::class, $dividendTax->dividendId),
            stockTicker: $dividendTax->stockTicker,
            exchangeRate: $this->entityManager->getReference(ExchangeRateEntity::class, $dividendTax->exchangeRate->id),
            dividendGrossAmount: $dividendTax->dividendGrossAmount,
            incomeTaxCurrency: $dividendTax->incomeTaxCurrency,
            withholdingTaxAmount: $dividendTax->withholdingTaxAmount,
            withholdingTaxRate: $dividendTax->withholdingTaxRate,
            incomeTaxRate: $dividendTax->incomeTaxRate,
            dividendAmountInTargetCurrencyGross: $dividendTax->calculatedIncomeTax->dividendAmountInTargetCurrencyGross,
            dividendWithholdingTaxInTargetCurrency: $dividendTax->calculatedIncomeTax->dividendWithholdingTaxInTargetCurrency,
            taxToPayInTargetCurrency: $dividendTax->calculatedIncomeTax->taxToPayInTargetCurrency,
            taxLeftToPayInTargetCurrency: $dividendTax->calculatedIncomeTax->taxLeftToPayInTargetCurrency,
            dividendAmountInTargetCurrencyNet: $dividendTax->calculatedIncomeTax->dividendAmountInTargetCurrencyNet,
        );

        $this->entityManager->persist($entity);
        $this->entityManager->flush();
    }

    public function read(int $dividendTaxId): ?DividendTax
    {
        return null;//@todo
    }
}