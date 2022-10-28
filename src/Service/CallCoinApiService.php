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
                    'X-CMC_PRO_API_KEY: 200cc19e-c73a-451e-bf44-ae744e33067b'
                ]
            ]
        );

        return $response->toArray();
    }
}