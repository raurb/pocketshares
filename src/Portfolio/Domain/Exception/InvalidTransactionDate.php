<?php

declare(strict_types=1);

namespace PocketShares\Portfolio\Domain\Exception;

use PocketShares\Portfolio\Domain\Transaction;

class InvalidTransactionDate extends \RuntimeException
{
    public function __construct(string $dateProvided)
    {
        parent::__construct(\sprintf(
            'Cannot create DateTime from provided date "%s". ExpectedFormat should be "%s"',
            $dateProvided,
            Transaction::TRANSACTION_DATE_FORMAT,
        ));
    }
}