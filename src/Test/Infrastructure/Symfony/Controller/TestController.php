<?php

declare(strict_types=1);

namespace PocketShares\Test\Infrastructure\Symfony\Controller;

use Doctrine\ORM\EntityManagerInterface;
use PocketShares\Shared\Infrastructure\Controller\ApiController;
use PocketShares\Shared\Utilities\MoneyFactory;
use PocketShares\Stock\Infrastructure\Doctrine\Entity\DividendPaymentEntity;
use PocketShares\Stock\Infrastructure\Doctrine\Entity\StockEntity;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/test', name: 'test_')]
class TestController extends ApiController
{
    #[Route('/', name: 'test')]
    public function test(EntityManagerInterface $entityManager): Response
    {
        $newDividendPayment = new DividendPaymentEntity(
            $entityManager->getReference(StockEntity::class, 33),
            new \DateTimeImmutable(),
            MoneyFactory::create(870, 'USD'),
        );
        $entityManager->persist($newDividendPayment);
        $entityManager->flush($newDividendPayment);
        return new Response();
    }
}