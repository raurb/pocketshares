<?php

declare(strict_types=1);

namespace PocketShares\ExchangeRates\Provider\Nbp\Api\Request;

interface RequestInterface
{
    public function getPath(): string;
    public function getQueryParameters(): array;
    public function getPayload(): array;
    public function getHeaders(): array;
    public function getMethod(): string;
}