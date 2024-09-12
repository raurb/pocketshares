<?php

declare(strict_types=1);

namespace PocketShares\Tax\Domain\Repository;

use PocketShares\Tax\Domain\DividendTax;

interface DividendTaxRepositoryInterface
{
    public function store(DividendTax $dividendTax): void;
    public function read(int $dividendTaxId): ?DividendTax;
}