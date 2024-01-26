<?php

declare(strict_types=1);

namespace PocketShares\Test\Infrastructure\Symfony\Controller;

use PocketShares\Portfolio\Application\Command\RegisterTransaction\RegisterTransactionCommand;
use PocketShares\Shared\Infrastructure\Controller\ApiController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/test', name: 'test_')]
class TestController extends ApiController
{
    #[Route('/', name: 'test')]
    public function test(): Response
    {
//        $command = new TestCommand();
        $command = new RegisterTransactionCommand(
            1,
            'AAPL',
            '2024-01-11 00:00:00',
            'SELL',
            8,
            900,
            'USD',
        );

        $this->commandBus->dispatch($command);
        return new Response();
    }
}