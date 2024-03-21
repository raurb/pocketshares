<?php

declare(strict_types=1);

namespace PocketShares\Stock\Application\Command\RegisterSystemDividend;

class RegisterDividendCommandIsNotLocked extends \RuntimeException
{
    public function __construct()
    {
        parent::__construct('Register dividend command is not locked.');
    }
}