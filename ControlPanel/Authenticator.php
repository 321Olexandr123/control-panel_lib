<?php


namespace ControlPanel;


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
        $tokenDecoded = new TokenDecoded(
            ['typ' => 'JWT', 'alg' => 'HS256'],
            [
                "type" => $type,
                "public" => $publicKey
            ]);
        $tokenEndcoded = $tokenDecoded->encode($secretKey);

        $client = new NativeHttpClient();

        $response = $client->request('POST', 'http://control-panel.com/v1/auth', [
            'headers' => [
                'Content-Type' => 'application/json',
            ],
            'json' => [
                'token' => $tokenEndcoded->__toString()
            ]
        ]);

        return $response->toArray();
    }
}