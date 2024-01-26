<?php

declare(strict_types=1);

namespace PocketShares\Portfolio\Domain\Exception;

use PocketShares\Portfolio\Domain\TransactionType;

class CannotHandleTransactionType extends \RuntimeException
{
    public function __construct(TransactionType $transactionType)
    {
        parent::__construct(\sprintf('There is no strategy implemented for transaction type "%s"', $transactionType->value));
    }
}