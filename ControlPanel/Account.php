<?php


namespace ControlPanel\ControlPanel;


use Symfony\Component\HttpClient\NativeHttpClient;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

class Account
{
    /**
     * @param string $type
     * @param string $publicKey
     * @param string $secretKey
     * @return array
     * @throws ClientExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     */
    public static function settings(string $type, string $publicKey, string $secretKey)
    {
        $client = new NativeHttpClient();

        $response = $client->request('GET', 'https://controlpanel.crpt.trading/project-settings/provider-crypto/huobi', [
            'headers' => [
                'Content-Type' => 'application/json',
            ],
            'json' => [
                'username' => $publicKey,
                'password' => $secretKey,
            ]
        ]);

        return $response->toArray();
    }
}