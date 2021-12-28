<?php

namespace Xofttion\JWT;

use DomainException;
use Xofttion\JWT\Algorithm;
use Xofttion\JWT\Decode\Config as DecodeConfig;
use Xofttion\JWT\Encode\Config as EncodeConfig;

class Sign
{
    public static function generate(string $value, EncodeConfig $config): ?string
    {
        $algorithm = static::algorithm($config->getAlg());

        switch ($algorithm->getMethod()) {
            case ('hash_hmac'):
                return static::signHMAC($value, $config->getKey(), $algorithm);

            case ('openssl'):
                return static::signSSL($value, $config->getKey(), $algorithm);

            default:
                return null;
        }
    }

    public static function verify(Token $token, DecodeConfig $config): bool
    {
        $algorithm = static::algorithm($token->getHeader()->alg);

        switch ($algorithm->getMethod()) {
            case ('hash_hmac'):
                return static::verifyHMAC($token, $config, $algorithm);

            case ('openssl'):
                return static::verifySSL($token, $config, $algorithm);

            default:
                return false;
        }
    }

    private static function algorithm(string $name): Algorithm
    {
        $algorithm = Algorithm::factory($name);

        if (is_null($algorithm)) {
            throw new DomainException('Algorithm config not supported');
        }

        return $algorithm;
    }

    private static function verifyHMAC(Token $token, DecodeConfig $config, Algorithm $alg): bool
    {
        list($headerb64, $payloadb64) = $token->getSegments();

        $value = "{$headerb64}.{$payloadb64}";

        $hash = static::signHMAC($value, $config->getKey(), $alg);

        return hash_equals($hash, $token->getSign());
    }

    private static function verifySSL(Token $token, DecodeConfig $config, Algorithm $alg): bool
    {
        list($headerb64, $payloadb64) = $token->getSegments();

        $value = "{$headerb64}.{$payloadb64}";
        $sign = $token->getSign();
        $key = $config->getKey();
        $algorithm = $alg->getName();

        $success = openssl_verify($value, $sign, $key, $algorithm);

        if ($success === 1) {
            return true;
        } elseif ($success === 0) {
            return false;
        } else {
            $errors = openssl_error_string();

            throw new DomainException("OpenSSL error: {$errors}");
        }
    }

    private static function signHMAC(string $value, string $key, Algorithm $alg): string
    {
        return hash_hmac($alg->getName(), $value, $key, true);
    }

    private static function signSSL(string $value, string $key, Algorithm $alg): string
    {
        $success = openssl_sign($value, $signature, $key, $alg->getName());

        if (!$success) {
            throw new DomainException('OpenSSL unable to sign data');
        }

        return $signature;
    }
}
