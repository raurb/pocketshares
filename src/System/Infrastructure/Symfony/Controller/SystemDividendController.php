<?php

declare(strict_types=1);

namespace PocketShares\System\Infrastructure\Symfony\Controller;

use PocketShares\Portfolio\Application\Query\GetPortfolioHoldings\GetPortfolioDetailsQuery;
use PocketShares\Shared\Infrastructure\Controller\ApiController;
use PocketShares\Stock\Application\Command\RegisterSystemDividend\RegisterSystemDividendCommand;
use PocketShares\System\Application\Query\GetAllSystemDividends\GetAllSystemDividendsQuery;
use PocketShares\System\Infrastructure\ReadModel\SystemDividendView;
use PocketShares\System\Infrastructure\Symfony\Form\RegisterSystemDividendType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/system/dividend', name: 'system_dividend_')]
class SystemDividendController extends ApiController
{
    #[Route(path: '/register-dividend', name: 'register_dividend', methods: ['GET', 'POST'])]
    public function registerSystemDividend(Request $request): Response
    {
        $form = $this->createForm(RegisterSystemDividendType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $formData = $form->getData();
            $command = new RegisterSystemDividendCommand(
                stockTicker: $formData['stock_ticker'],
                payoutDate: \DateTimeImmutable::createFromMutable($formData['payout_date']),
                amount: (int)($formData['price']['price'] * 100),
                amountCurrency: $formData['price']['currency']
            );

            $this->commandBus->dispatch($command);

            return $this->render(
                'system/_system_dividend_list.html.twig', [
                    'dividends' => $this->queryBus->dispatch(new GetAllSystemDividendsQuery())
                ]
            );
        }

        return $this->render('system/_system_register_dividend.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route(path: '/list', name: 'list', methods: ['GET'])]
    public function list(): Response
    {
        return $this->render(
            'system/_system_dividend_list.html.twig', [
                'dividends' => $this->queryBus->dispatch(new GetAllSystemDividendsQuery())
            ]
        );
    }
}