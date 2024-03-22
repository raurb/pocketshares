<?php

declare(strict_types=1);

namespace PocketShares\Portfolio\Infrastructure\Symfony\Form\Type;

use PocketShares\Portfolio\Domain\TransactionType;
use PocketShares\Shared\Infrastructure\Symfony\Form\QueryAwareType;
use PocketShares\Shared\Infrastructure\Symfony\Form\Type\PriceType;
use PocketShares\Stock\Application\Query\GetAllStocks\GetAllStocksQuery;
use PocketShares\Stock\Infrastructure\ReadModel\StockView;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;

class RegisterTransactionType extends QueryAwareType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('stock_ticker', ChoiceType::class, ['choices' => $this->getStockChoices(), 'required' => true, 'label' => 'Stock'])
            ->add('transaction_type', ChoiceType::class, ['choices' => TransactionType::getLabels(), 'required' => true, 'label' => 'Transaction type'])
            ->add('number_of_shares', NumberType::class, ['required' => false])
            ->add('price', PriceType::class, ['label' => 'Price per share', 'required' => true])
            ->add('transaction_date', DateType::class)
            ->add('register_transaction', SubmitType::class);
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