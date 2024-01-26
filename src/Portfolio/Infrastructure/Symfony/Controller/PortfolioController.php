<?php

declare(strict_types=1);

namespace PocketShares\Portfolio\Infrastructure\Symfony\Controller;

use PocketShares\Portfolio\Application\Command\CreatePortfolio\CreatePortfolioCommand;
use PocketShares\Portfolio\Application\Query\GetAllPortfoliosQuery;
use PocketShares\Portfolio\Infrastructure\Symfony\Form\Type\CreatePortfolioType;
use PocketShares\Shared\Infrastructure\Controller\ApiController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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
        }

        return $this->render('portfolio/_portfolio_create.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/list', name: 'list')]
    public function list(): Response
    {
        return $this->render('portfolio/_portfolio_list.html.twig', [
            'portfolios' => $this->queryBus->ask(new GetAllPortfoliosQuery()),
        ]);
    }
}