<?php

namespace Xofttion\JWT;

class Signature
{
    public const HMAC_SHA256 = 'HS256';

    public const HMAC_SHA384 = 'HS384';

    public const HMAC_SHA512 = 'HS512';

    public const RSASSA_SHA256 = 'RS256';

    public const RSASSA_SHA384 = 'RS384';

    public const RSASSA_SHA512 = 'RS512';

    public const ECDSA_SHA256 = 'ES256';

    private string $name;

    private string $algorithm;

    private function __construct(string $name, string $algorithm)
    {
        $this->name = $name;
        $this->algorithm = $algorithm;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getAlgorithm(): string
    {
        return $this->algorithm;
    }

    public static function factory(string $name): ?Signature
    {
        switch ($name) {
            case (static::HMAC_SHA256):
                return new Signature('hash_hmac', 'SHA256');

            case (static::HMAC_SHA384):
                return new Signature('hash_hmac', 'SHA384');

            case (static::HMAC_SHA512):
                return new Signature('hash_hmac', 'SHA512');

            case (static::RSASSA_SHA256):
                return new Signature('openssl', 'SHA256');

            case (static::RSASSA_SHA384):
                return new Signature('openssl', 'SHA384');

            case (static::RSASSA_SHA512):
                return new Signature('openssl', 'SHA512');

            case (static::ECDSA_SHA256):
                return new Signature('openssl', 'SHA256');

            default:
                return null;
        }
    }
}
