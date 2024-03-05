<?php

declare(strict_types=1);

namespace PocketShares\Test\Infrastructure\Symfony\Controller;

use PocketShares\Portfolio\Application\Command\RegisterTransaction\RegisterTransactionCommand;
use PocketShares\Shared\Infrastructure\Controller\ApiController;
use PocketShares\Stock\Application\Command\RegisterSystemDividend\RegisterSystemDividendCommand;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/test', name: 'test_')]
class TestController extends ApiController
{
    #[Route('/', name: 'test')]
    public function test(): Response
    {
//        $command = new TestCommand();
        $command = new RegisterSystemDividendCommand('AVGO', (new \DateTimeImmutable())->format('Y-m-d'), 14, 'USD');

        $this->commandBus->dispatch($command);
        return new Response();
    }
}