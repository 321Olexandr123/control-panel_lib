<?php


namespace ControlPanel\ControlPanel;


use Symfony\Component\HttpClient\NativeHttpClient;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

/**
 * Class Document
 * @package ControlPanel\ControlPanel
 */
class Document
{
    /**
     * @param string $authToken
     * @param string $email
     * @param string $callUrl
     * @param string $connection
     * @return array
     * @throws ClientExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     */
    public static function verify(string $authToken, string $email, string $callUrl, string $connection)
    {
        $client = new NativeHttpClient();

        $response = $client->request('POST', 'https://dev5.itlab-studio.com/api/private/documents', [
            'headers' => [
                'Content-Type' => 'application/json',
                'Authorization' => 'JWS-AUTH-TOKEN ' . $authToken
            ],
            'json' => [
                "email" => $email,
                "callUrl" => $callUrl,
                "connection" => $connection,
            ]
        ]);
        return $response->toArray();
    }
}