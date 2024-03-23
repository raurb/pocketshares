<?php

declare(strict_types=1);

namespace PocketShares\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use PocketShares\Portfolio\Infrastructure\Doctrine\Entity\PortfolioEntity;

class Portfolios extends Fixture
{
    protected const array PORTFOLIOS = [
        'Stocks' => ['currency' => 'USD'],
        'ETFs' => ['currency' => 'USD'],
    ];

    public function load(ObjectManager $manager): void
    {
        foreach (self::PORTFOLIOS as $name => $portfolio) {
            $portfolioEntity = new PortfolioEntity($name, $portfolio['currency']);
            $manager->persist($portfolioEntity);

            $this->addReference(\sprintf('portfolio_%s', \strtolower($name)), $portfolioEntity);
        }

        $manager->flush();
    }
}