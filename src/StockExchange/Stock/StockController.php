<?php

declare(strict_types=1);

namespace PocketShares\StockExchange\Stock;

use PocketShares\StockExchange\Stock\Form\Type\AddStockType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/stock', name: 'stock_')]
class StockController extends AbstractController
{
    #[Route('/add', name: 'add')]
    public function add(Request $request, StockService $stockService): Response
    {
        $form = $this->createForm(AddStockType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $formData = $form->getData();
            $stock = StockDto::with(
                name: $formData['name'],
                ticker: $formData['ticker'],
                symbol: $formData['symbol'],
            );
            $stockService->add($stock);
        }

        return $this->render('stock/stock_add.html.twig', [
            'form' => $form,
        ]);
    }
}