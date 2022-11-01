<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class CallCoinApiService 
{
    private $client;

    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }

    public function getCoinPriceData(): array
    {
        $response = $this->client->request(
            'GET',
            'https://pro-api.coinmarketcap.com/v2/cryptocurrency/quotes/latest',
            [
                'query' => [
                    'id' => '1,1027,52',
                    'convert' => 'EUR'
                ],
                'headers' => [
                    'Accepts: application/json',
                    'X-CMC_PRO_API_KEY: ' . $_ENV['API_KEY'],
                ]
            ]
        );

        return $response->toArray();
    }
}
