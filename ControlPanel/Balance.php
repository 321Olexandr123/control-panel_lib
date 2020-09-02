<?php


namespace ControlPanel\ControlPanel;


use Symfony\Component\HttpClient\NativeHttpClient;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

class Balance
{
    /**
     * @param string $authToken
     * @param string $currency
     * @return int|mixed
     * @throws ClientExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     */
    public static function getAll(string $authToken, string $currency)
    {
        $client = new NativeHttpClient();
        $response = $client->request('GET', 'https://dev9.itlab-studio.com/api/private/balances?currency=' . strtolower($currency), [
            'headers' => [
                'Content-Type' => 'application/json',
                'Authorization' => 'JWS-AUTH-TOKEN ' . $authToken
            ],
        ]);
        return $response->toArray();
    }

    /**
     * @param string $authToken
     * @param string $currency
     * @return int|mixed
     * @throws ClientExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     */
    public static function getByAbbr(string $authToken, string $currency)
    {
        $client = new NativeHttpClient();
        $response = $client->request('GET', 'https://dev9.itlab-studio.com/api/private/balances?currency.asset=' . strtolower($currency), [
            'headers' => [
                'Content-Type' => 'application/json',
                'Authorization' => 'JWS-AUTH-TOKEN ' . $authToken
            ],
        ]);
        return $response->toArray()[0]['amount'] ?? 0;
    }
}