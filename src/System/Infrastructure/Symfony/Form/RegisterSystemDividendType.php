<?php

declare(strict_types=1);

namespace PocketShares\System\Infrastructure\Symfony\Form;

use PocketShares\Shared\Infrastructure\Symfony\Form\QueryAwareType;
use PocketShares\Shared\Infrastructure\Symfony\Form\Type\PriceType;
use PocketShares\Stock\Application\Query\GetAllStocks\GetAllStocksQuery;
use PocketShares\Stock\Infrastructure\ReadModel\StockView;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;

class RegisterSystemDividendType extends QueryAwareType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('stock_ticker', ChoiceType::class, ['choices' => $this->getStockChoices(), 'required' => true, 'label' => 'Stock'])
            ->add('payout_date', DateType::class)
            ->add('price', PriceType::class, ['label' => false, 'required' => true])
            ->add('register_dividend', SubmitType::class);
    }

    private function getStockChoices(): array
    {
        $stocks = $this->queryBus->dispatch(new GetAllStocksQuery());

        if (!$stocks) {
            return [];
        }

        $choices = [];
        /** @var StockView $stock */
        foreach ($stocks as $stock) {
            $choices[\sprintf('%s %s', $stock->ticker, $stock->name)] = $stock->ticker;
        }

        return $choices;
    }
}