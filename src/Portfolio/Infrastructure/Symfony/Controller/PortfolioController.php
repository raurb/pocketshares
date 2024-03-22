<?php

declare(strict_types=1);

namespace PocketShares\Portfolio\Infrastructure\Symfony\Controller;

use PocketShares\Portfolio\Application\Command\CreatePortfolio\CreatePortfolioCommand;
use PocketShares\Portfolio\Application\Command\RegisterTransaction\RegisterTransactionCommand;
use PocketShares\Portfolio\Application\Query\GetAllPortfolios\GetAllPortfoliosQuery;
use PocketShares\Portfolio\Application\Query\GetPortfolioHoldings\GetPortfolioDetailsQuery;
use PocketShares\Portfolio\Application\Query\GetPortfolioDividends\GetPortfolioDividendsQuery;
use PocketShares\Portfolio\Application\Query\GetPortfolioTransactions\GetPortfolioTransactionsQuery;
use PocketShares\Portfolio\Infrastructure\Symfony\Form\Type\CreatePortfolioType;
use PocketShares\Portfolio\Infrastructure\Symfony\Form\Type\RegisterTransactionType;
use PocketShares\Shared\Domain\NumberOfShares;
use PocketShares\Shared\Infrastructure\Controller\ApiController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/portfolio', name: 'portfolio_')]
class PortfolioController extends ApiController
{
    #[Route('/create', name: 'create')]
    public function create(Request $request): Response
    {
        $form = $this->createForm(CreatePortfolioType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $formData = $form->getData();
            $command = new CreatePortfolioCommand(
                name: $formData['name'],
                currencyCode:$formData['currency_code'],
            );

            $this->commandBus->dispatch($command);

            return $this->render('portfolio/_portfolio_list.html.twig', [
                'portfolios' => $this->queryBus->dispatch(new GetAllPortfoliosQuery()),
            ]);
        }

        return $this->render('portfolio/_portfolio_create.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/list', name: 'list')]
    public function list(): Response
    {
        return $this->render('portfolio/_portfolio_list.html.twig', [
            'portfolios' => $this->queryBus->dispatch(new GetAllPortfoliosQuery()),
        ]);
    }

    #[Route('/{id}/details', name: 'details', methods: ['GET'])]
    public function portfolioHoldings(int $id): Response
    {
        return $this->render('portfolio/_portfolio_details.html.twig', [
            'portfolio' => $this->queryBus->dispatch(new GetPortfolioDetailsQuery($id)) ?? [],
        ]);
    }

    #[Route('/{id}/register-transaction', name: 'register_transaction', methods: ['GET', 'POST'])]
    public function registerTransaction(int $id, Request $request): Response
    {
        $form = $this->createForm(RegisterTransactionType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $formData = $form->getData();
            $command = new RegisterTransactionCommand(
                portfolioId: $id,
                stockTicker: $formData['stock_ticker'],
                transactionDate: \DateTimeImmutable::createFromMutable($formData['transaction_date']),
                transactionType: $formData['transaction_type'],
                pricePerShare: (int)($formData['price']['price'] * 100),
                numberOfShares: (new NumberOfShares($formData['number_of_shares'] ?? 0))->getNumberOfShares(),
                priceCurrency: $formData['price']['currency'],
            );

            $this->commandBus->dispatch($command);

            return $this->render('portfolio/_portfolio_details.html.twig', [
                'portfolio' => $this->queryBus->dispatch(new GetPortfolioDetailsQuery($id)) ?? [],
            ]);
        }

        return $this->render('portfolio/_portfolio_register_transaction.html.twig', [
            'portfolioId' => $id,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/transactions', name: 'transactions', methods: ['GET'])]
    public function portfolioTransactions(int $id): Response
    {
        return $this->render('portfolio/_portfolio_transactions.html.twig', [
            'portfolioId' => $id,
            'transactions' => $this->queryBus->dispatch(new GetPortfolioTransactionsQuery($id)) ?? [],
        ]);
    }

    #[Route('/{id}/dividends', name: 'dividends', methods: ['GET'])]
    public function portfolioDividends(int $id): Response
    {
        return $this->render('portfolio/_portfolio_dividend_list.html.twig', [
            'portfolioId' => $id,
            'dividends' => $this->queryBus->dispatch(new GetPortfolioDividendsQuery($id)) ?? [],
        ]);
    }
}