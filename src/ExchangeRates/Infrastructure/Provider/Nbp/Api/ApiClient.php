<?php

declare(strict_types=1);

namespace PocketShares\ExchangeRates\Infrastructure\Provider\Nbp\Api;

use GuzzleHttp\ClientInterface;
use PocketShares\ExchangeRates\Infrastructure\Provider\Nbp\Api\Request\ExchangeRatesRequest;
use PocketShares\ExchangeRates\Infrastructure\Provider\Nbp\Api\Request\RequestInterface;
use PocketShares\ExchangeRates\Infrastructure\Provider\Nbp\Api\Response\ExchangeRatesResponse;

class ApiClient
{
    private const URI = 'http://api.nbp.pl/api';

    public function __construct(public readonly ClientInterface $client)
    {
    }

    public function getMidExchangeRatesForCurrency(ExchangeRatesRequest $exchangeRatesRequest): ExchangeRatesResponse
    {
        $response = $this->makeRequest($exchangeRatesRequest);

        return (new ExchangeRatesResponse($response));
    }

    private function makeRequest(RequestInterface $request): array
    {
        $response = $this->client->request(
            $request->getMethod(),
            $this->getUri($request->getPath()),
            [
                'headers' => $this->getHeaders($request->getHeaders()),
                'query' => $request->getQueryParameters(),
            ],
        );

        return \json_decode($response->getBody()->getContents(), true, 512, JSON_THROW_ON_ERROR);
    }

    private function getUri(string $path): string
    {
        return self::URI . '/' . \ltrim($path, '/');
    }

    private function getHeaders(array $headers): array
    {
        return \array_merge(['Accept' => 'application/json'], $headers);
    }
}