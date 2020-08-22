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
     * @param array $attributes
     * @return array
     * @throws ClientExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     */
    public static function verify(
        string $authToken,
        string $email,
        string $callUrl,
        string $connection,
        array $attributes
    ): array {
        $client = new NativeHttpClient();

        $response = $client->request(
            'POST',
            'https://dev9.itlab-studio.com/api/private/documents',
            [
                'headers' => [
                    'Content-Type'  => 'application/json',
                    'Authorization' => 'JWS-AUTH-TOKEN ' . $authToken
                ],
                'json'    => [
                    "email"      => $email,
                    "connection" => $connection,
                    "attributes" => $attributes,
                    "callUrl"    => $callUrl,
                ]
            ]
        );

        return $response->toArray();
    }
}