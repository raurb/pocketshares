<?php

declare(strict_types=1);

namespace PocketShares\Portfolio\Domain\Exception;

class PortfolioNotFoundException extends \RuntimeException
{
    public function __construct(int $ticker)
    {
        parent::__construct(\sprintf('Portfolio with given ID "%d" does not exist.', $ticker));
    }
}