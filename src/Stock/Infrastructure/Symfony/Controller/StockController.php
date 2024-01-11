<?php

declare(strict_types=1);

namespace PocketShares\Stock\Infrastructure\Symfony\Controller;

use PocketShares\Shared\Infrastructure\Controller\ApiController;
use PocketShares\Stock\Application\Command\CreateStock\CreateStockCommand;
use PocketShares\Stock\Application\Query\GetAllStocks\GetAllStocksQuery;
use PocketShares\Stock\Infrastructure\Symfony\Form\Type\AddStockType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/stock', name: 'stock_')]
class StockController extends ApiController
{
    #[Route('/add', name: 'add')]
    public function add(Request $request): Response
    {
        $form = $this->createForm(AddStockType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $formData = $form->getData();
            $command = new CreateStockCommand(
                name: $formData['name'],
                ticker: $formData['ticker'],
                marketSymbol: ($formData['market_symbol'])->value,
                currency: $formData['currency'],
            );

            $this->commandBus->handle($command);
        }

        return $this->render('stock/_stock_add.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/list', name: 'list')]
    public function list(): Response
    {
        return $this->render('stock/_stock_list.html.twig', [
            'stocks' => $this->queryBus->ask(new GetAllStocksQuery()),
        ]);
    }
}