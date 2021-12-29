<?php

namespace Xofttion\JWT;

use DomainException;
use Xofttion\JWT\Decode\Config as DecodeConfig;
use Xofttion\JWT\Encode\Config as EncodeConfig;

class Sign
{
    // Métodos estáticos de la clase Sign

    public static function generate(string $value, EncodeConfig $config): ?string
    {
        $signature = static::method($config->getMethod());

        switch ($signature->getName()) {
            case ('hash_hmac'):
                return static::signHMAC($value, $config->getKey(), $signature);

            case ('openssl'):
                return static::signSSL($value, $config->getKey(), $signature);

            default:
                return null;
        }
    }

    public static function verify(Token $token, DecodeConfig $config): bool
    {
        $signature = static::method($token->getHeader()->alg);

        switch ($signature->getName()) {
            case ('hash_hmac'):
                return static::verifyHMAC($token, $config, $signature);

            case ('openssl'):
                return static::verifySSL($token, $config, $signature);

            default:
                return false;
        }
    }

    private static function method(string $name): Signature
    {
        $signature = Signature::factory($name);

        if (is_null($signature)) {
            throw new DomainException("Signature method {$name} config not supported");
        }

        return $signature;
    }

    private static function verifyHMAC(Token $token, DecodeConfig $config, Signature $sign): bool
    {
        list($headerb64, $payloadb64) = $token->getSegments();

        $value = "{$headerb64}.{$payloadb64}";

        $hash = static::signHMAC($value, $config->getKey(), $sign);

        return hash_equals($hash, $token->getSign());
    }

    private static function verifySSL(Token $token, DecodeConfig $config, Signature $sign): bool
    {
        list($headerb64, $payloadb64) = $token->getSegments();

        $value = "{$headerb64}.{$payloadb64}";
        $signToken = $token->getSign();
        $key = $config->getKey();
        $algorithm = $sign->getAlgorithm();

        $success = openssl_verify($value, $signToken, $key, $algorithm);

        if ($success === 1) {
            return true;
        } elseif ($success === 0) {
            return false;
        } else {
            $errors = openssl_error_string();

            throw new DomainException("OpenSSL error: {$errors}");
        }
    }

    private static function signHMAC(string $value, string $key, Signature $sign): string
    {
        return hash_hmac($sign->getAlgorithm(), $value, $key, true);
    }

    private static function signSSL(string $value, string $key, Signature $sign): string
    {
        $success = openssl_sign($value, $signValue, $key, $sign->getAlgorithm());

        if (!$success) {
            throw new DomainException('OpenSSL unable to sign data');
        }

        return $signValue;
    }
}
