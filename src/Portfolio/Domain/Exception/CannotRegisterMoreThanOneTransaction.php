<?php

declare(strict_types=1);

namespace PocketShares\Portfolio\Domain\Exception;

class CannotRegisterMoreThanOneTransaction extends \RuntimeException
{
    public function __construct()
    {
        parent::__construct('Cannot register more than one transaction at the same time');
    }
}