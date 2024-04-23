<?php

declare(strict_types=1);

namespace PocketShares\Portfolio\Domain\Exception;

use PocketShares\Portfolio\Domain\TransactionType;
use PocketShares\Shared\Domain\NumberOfShares;

class BuySellTransactionNoNumberOfSharesException extends \Exception
{
    public function __construct(TransactionType $transactionType, ?NumberOfShares $numberOfShares)
    {
        parent::__construct(\sprintf(
            'Transaction type %s or %s must contain number of shares. Transaction type provided: "%s", number of shares provided %s',
            TransactionType::TYPE_BUY->name,
            TransactionType::TYPE_SELL->name,
            $transactionType->name,
            $numberOfShares ? (string)$numberOfShares->getNumberOfShares() : 'null',
        ));
    }
}