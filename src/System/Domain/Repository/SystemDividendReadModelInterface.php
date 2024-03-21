<?php

declare(strict_types=1);

namespace PocketShares\System\Domain\Repository;

use PocketShares\System\Infrastructure\ReadModel\SystemDividendView;

interface SystemDividendReadModelInterface
{
    /** @return SystemDividendView[] */
    public function getAllSystemDividends(?int $limit = null, ?int $offset = null): array;
}