<?php


namespace ControlPanel\ControlPanel;


use Symfony\Component\HttpClient\NativeHttpClient;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

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
     * @param string $key
     * @param string $type
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
        string $key,
        string $type
    )
    {
        $signature = EncryptionManager::encodeSignature($paymentSystem . ':' . $amount . ':' . $currency . ':' . $referenceId . ':' . $connection . ':' . $type, $key);

        $client = new NativeHttpClient();

        $response = $client->request('POST', 'https://dev5.itlab-studio.com/api/private/payments', [
            'headers' => [
                'Content-Type' => 'application/json',
                'Authorization' => 'JWS-AUTH-TOKEN ' . $authToken
            ],
            'json' => [
                "paymentSystem" => $paymentSystem,
                "amount" => $amount,
                "currency" => $currency,
                "referenceId" => $referenceId,
                "callUrl" => $callUrl,
                "returnUrl" => $returnUrl,
                "connection" => $connection,
                "signature" => $signature,
                "type" => $type
            ]
        ]);
        return $response->toArray();
    }

    /**
     * @param string $authToken
     * @param string $connection
     * @param string $paymentSystem
     * @param string $amount
     * @param array $properties
     * @param string $currency
     * @param string $referenceId
     * @param string $callUrl
     * @param string $key
     * @param string $type
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
        array $properties,
        string $currency,
        string $referenceId,
        string $callUrl,
        string $key,
        string $type
    )
    {
        $signature = EncryptionManager::encodeSignature($paymentSystem . ':' . $amount . ':' . $currency . ':' . $referenceId . ':' . $connection . ':' . $type . ':' . base64_encode(json_encode($properties)), $key);

        $client = new NativeHttpClient();

        $response = $client->request('POST', 'https://dev5.itlab-studio.com/api/private/payouts', [
            'headers' => [
                'Content-Type' => 'application/json',
                'Authorization' => 'JWS-AUTH-TOKEN ' . $authToken
            ],
            'json' => [
                "paymentSystem" => $paymentSystem,
                "amount" => $amount,
                "currency" => $currency,
                "properties" => $properties,
                "referenceId" => $referenceId,
                "callUrl" => $callUrl,
                "connection" => $connection,
                "signature" => $signature,
                "type" => $type
            ]
        ]);
        return $response->toArray();
    }
}