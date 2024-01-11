<?php

namespace PocketShares\Shared\Infrastructure\Exception;

class CannotBuildMoneyException extends \Exception
{
    public function __construct(array $parameters)
    {
        parent::__construct(\sprintf('Cannot build Money object with given parameters: "%s"', json_encode($parameters)));
    }
}