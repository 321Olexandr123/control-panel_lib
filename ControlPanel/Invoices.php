<?php


namespace ControlPanel\ControlPanel;


use Symfony\Component\HttpClient\NativeHttpClient;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

/**
 * Class Invoices
 * @package ControlPanel\ControlPanel
 */
class Invoices
{
    /**
     * @param string $authToken
     * @param string $connection
     * @param string $paymentSystem
     * @param string $amount
     * @param string $currency
     * @param string $referenceId
     * @param string $callUrl
     * @param string $returnUrl
     * @param array $attributes
     * @param string $key
     * @return array
     * @throws ClientExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     */
    public static function payment(
        string $authToken,
        string $connection,
        string $paymentSystem,
        string $amount,
        string $currency,
        string $referenceId,
        string $callUrl,
        string $returnUrl,
        array $attributes,
        string $key
    ): array {
        $signature = EncryptionManager::encodeSignature(
            $paymentSystem . ':' . $amount . ':' . $currency . ':' . $referenceId . ':' . $connection . ':' . base64_encode(
                json_encode($attributes)
            ),
            $key
        );

        $client = new NativeHttpClient();

        $response = $client->request(
            'POST',
            'https://dev9.itlab-studio.com/api/private/payments',
            [
                'headers' => [
                    'Content-Type'  => 'application/json',
                    'Authorization' => 'JWS-AUTH-TOKEN ' . $authToken
                ],
                'json'    => [
                    "paymentSystem" => $paymentSystem,
                    "amount"        => $amount,
                    "currency"      => $currency,
                    "referenceId"   => $referenceId,
                    "connection"    => $connection,
                    "returnUrl"     => $returnUrl,
                    "attributes"    => $attributes,
                    "callUrl"       => $callUrl,
                    "signature"     => $signature,
                ]
            ]
        );

        return $response->toArray();
    }

    /**
     * @param string $authToken
     * @param string $connection
     * @param string $paymentSystem
     * @param string $amount
     * @param string $currency
     * @param string $referenceId
     * @param string $callUrl
     * @param array $attributes
     * @param string $key
     * @return array
     * @throws ClientExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     */
    public static function payout(
        string $authToken,
        string $connection,
        string $paymentSystem,
        string $amount,
        string $currency,
        string $referenceId,
        string $callUrl,
        array $attributes,
        string $key
    ): array {
        $signature = EncryptionManager::encodeSignature(
            $paymentSystem . ':' . $amount . ':' . $currency . ':' . $referenceId . ':' . $connection . ':' . base64_encode(
                json_encode($attributes)
            ),
            $key
        );

        $client = new NativeHttpClient();

        $response = $client->request(
            'POST',
            'https://dev9.itlab-studio.com/api/private/payouts',
            [
                'headers' => [
                    'Content-Type'  => 'application/json',
                    'Authorization' => 'JWS-AUTH-TOKEN ' . $authToken
                ],
                'json'    => [
                    "paymentSystem" => $paymentSystem,
                    "amount"        => $amount,
                    "currency"      => $currency,
                    "referenceId"   => $referenceId,
                    "connection"    => $connection,
                    "attributes"    => $attributes,
                    "callUrl"       => $callUrl,
                    "signature"     => $signature,
                ]
            ]
        );

        return $response->toArray();
    }
}