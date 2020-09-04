<?php


namespace ControlPanel\ControlPanel;


use Symfony\Component\HttpClient\NativeHttpClient;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

/**
 * Class Fee
 * @package ControlPanel\ControlPanel
 */
class Fee
{
    /**
     * @param string $authToken
     * @return int|mixed
     * @throws ClientExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     */
    public static function getAll(string $authToken)
    {
        $client = new NativeHttpClient();
        $response = $client->request(
            'GET',
            'https://dev9.itlab-studio.com/api/private/fees',
            [
                'headers' => [
                    'Content-Type'  => 'application/json',
                    'Authorization' => 'JWS-AUTH-TOKEN ' . $authToken
                ],
            ]
        );

        return $response->toArray();
    }

    /**
     * @param string $authToken
     * @param string $feeId
     * @return int|mixed
     * @throws ClientExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     */
    public static function getById(string $authToken, string $feeId)
    {
        $client = new NativeHttpClient();
        $response = $client->request(
            'GET',
            'https://dev9.itlab-studio.com/api/private/fees/' . $feeId,
            [
                'headers' => [
                    'Content-Type'  => 'application/json',
                    'Authorization' => 'JWS-AUTH-TOKEN ' . $authToken
                ],
            ]
        );

        return $response->toArray();
    }
}