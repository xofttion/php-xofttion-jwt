<?php

namespace Xofttion\JWT;

class Algorithm
{
    public const HS256 = 'HS256';

    public const HS384 = 'HS384';

    public const HS512 = 'HS512';

    public const RS256 = 'RS256';

    public const RS384 = 'RS384';

    public const RS512 = 'RS512';

    public const ES256 = 'ES256';

    private $method;

    private $name;

    private function __construct(string $method, string $name)
    {
        $this->method = $method;
        $this->name = $name;
    }

    public function getMethod(): string
    {
        return $this->method;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public static function factory(string $alg): ?Algorithm
    {
        switch ($alg) {
            case (static::HS256):
                return new Algorithm('hash_hmac', 'SHA256');

            case (static::HS384):
                return new Algorithm('hash_hmac', 'SHA384');

            case (static::HS512):
                return new Algorithm('hash_hmac', 'SHA512');

            case (static::RS256):
                return new Algorithm('openssl', 'SHA256');

            case (static::RS384):
                return new Algorithm('openssl', 'SHA384');

            case (static::RS512):
                return new Algorithm('openssl', 'SHA512');

            case (static::ES256):
                return new Algorithm('openssl', 'SHA256');

            default:
                return null;
        }
    }
}
