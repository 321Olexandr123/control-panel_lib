<?php


namespace ControlPanel\ControlPanel;


use Nowakowskir\JWT\TokenDecoded;
use Symfony\Component\HttpClient\NativeHttpClient;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

class Authenticator
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
    public static function login(string $type, string $publicKey, string $secretKey)
    {
        $client = new NativeHttpClient();

        $response = $client->request('POST', 'http://controlpanel.crpt.trading/v1/auth', [
            'headers' => [
                'Content-Type' => 'application/json',
            ],
            'json' => [
                'username' => $publicKey,
                'password' => $secretKey,
                'type' => $type
            ]
        ]);

        return $response->toArray();
    }
}