<?php

namespace Xofttion\JWT;

class Signature
{
    // Constantes de la clase Signature

    public const HMAC_SHA256 = 'HMAC_SHA256';

    public const HMAC_SHA384 = 'HMAC_SHA384';

    public const HMAC_SHA512 = 'HMAC_SHA512';

    public const RSASSA_SHA256 = 'RSASSA_SHA256';

    public const RSASSA_SHA384 = 'RSASSA_SHA384';

    public const RSASSA_SHA512 = 'RSASSA_SHA512';

    public const ECDSA_SHA256 = 'ECDSA_SHA256';

    // Atributos de la clase Signature

    private $name;

    private $algorithm;

    // Constructor de la clase Signature

    private function __construct(string $name, string $algorithm)
    {
        $this->name = $name;
        $this->algorithm = $algorithm;
    }

    // Métodos de la clase Signature

    public function getName(): string
    {
        return $this->name;
    }

    public function getAlgorithm(): string
    {
        return $this->algorithm;
    }

    // Métodos estáticos de la clase Signature

    public static function factory(string $alg): ?Signature
    {
        switch ($alg) {
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