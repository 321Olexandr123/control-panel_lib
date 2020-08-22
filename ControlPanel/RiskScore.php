<?php


namespace ControlPanel\ControlPanel;


use Symfony\Component\HttpClient\NativeHttpClient;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

/**
 * Class RiskScore
 * @package ControlPanel\ControlPanel
 */
class RiskScore
{
    /**
     * @param string $authToken
     * @param string $asset
     * @param string $address
     * @param string $txhash
     * @param array $attributes
     * @param string $connection
     * @return array
     * @throws ClientExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     */
    public static function check(
        string $authToken,
        string $asset,
        string $address,
        string $txhash,
        array $attributes,
        string $connection
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
                    "asset"      => $asset,
                    "address"    => $address,
                    "txhash"     => $txhash,
                    "attributes" => $attributes,
                    "connection" => $connection
                ]
            ]
        );

        return $response->toArray();
    }

    /**
     * @param string $authToken
     * @param string $id
     * @return array
     * @throws ClientExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     */
    public static function checkById(string $authToken, string $id): array
    {
        $client = new NativeHttpClient();

        $response = $client->request(
            'GET',
            'https://dev9.itlab-studio.com/api/private/risk_scores/' . $id,
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