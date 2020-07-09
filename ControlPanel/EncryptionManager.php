<?php


namespace ControlPanel\ControlPanel;


use Firebase\JWT\JWT;

/**
 * Class EncryptionManager
 * @package App\Service
 */
class EncryptionManager
{
    /**
     * @param string $data
     * @param string $key
     * @return string
     */
    public static function encodeSignature(string $data, string $key)
    {
        return base64_encode(hash_hmac('sha256', $data, $key, true));
    }

    /**
     * @param string $projectId
     * @param int $iat
     * @param int $exp
     * @param string $key
     * @return string
     */
    public static function encodeJWS(string $projectId, int $iat, int $exp, string $key)
    {
        return JWT::encode([
            'projectId' => $projectId,
            'iat' => $iat,
            'exp' => $exp
        ], $key);
    }
}