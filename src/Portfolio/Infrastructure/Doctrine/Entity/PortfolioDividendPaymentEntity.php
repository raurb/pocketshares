<?php

declare(strict_types=1);

namespace PocketShares\Portfolio\Infrastructure\Doctrine\Entity;

use Doctrine\ORM\Mapping as ORM;
use PocketShares\Shared\Domain\NumberOfShares;
use PocketShares\Shared\Infrastructure\Doctrine\Entity\BaseEntity;
use PocketShares\System\Infrastructure\Doctrine\Entity\SystemDividendPaymentEntity;

#[Orm\Entity]
#[ORM\Table(name: "portfolio_dividend_payment")]
class PortfolioDividendPaymentEntity extends BaseEntity
{
    #[ORM\ManyToOne(targetEntity: PortfolioEntity::class, inversedBy: 'dividendPayments')]
    #[ORM\JoinColumn(nullable: false)]
    private PortfolioEntity $portfolio;

    #[ORM\ManyToOne(targetEntity: SystemDividendPaymentEntity::class)]
    #[ORM\JoinColumn(name: 'dividend_payment_id', nullable: false)]
    private SystemDividendPaymentEntity $dividendPaymentEntity;

    #[Orm\Column(name: 'number_of_shares', type: 'number_of_shares_type', precision: NumberOfShares::PRECISION, scale: NumberOfShares::SCALE)]
    private NumberOfShares $numberOfShares;

    public function __construct(PortfolioEntity $portfolio, SystemDividendPaymentEntity $dividendPaymentEntity, NumberOfShares $numberOfShares)
    {
        $this->portfolio = $portfolio;
        $this->dividendPaymentEntity = $dividendPaymentEntity;
        $this->numberOfShares = $numberOfShares;
    }

    public function getPortfolio(): PortfolioEntity
    {
        return $this->portfolio;
    }

    public function getDividendPaymentEntity(): SystemDividendPaymentEntity
    {
        return $this->dividendPaymentEntity;
    }

    public function getNumberOfShares(): NumberOfShares
    {
        return $this->numberOfShares;
    }
}