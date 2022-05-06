<?php

namespace Xofttion\JWT\Decode;

use UnexpectedValueException;
use Xofttion\JWT\Sign;
use Xofttion\JWT\Token;
use Xofttion\JWT\Exceptions\SignatureInvalidException;

class Service
{
    public static function rfc7519(Config $config): Token
    {
        $segments = static::getSegments($config);

        $token = static::generateToken($segments);

        $valid = Sign::verify($token, $config);

        if (!$valid) {
            throw new SignatureInvalidException('Signature verification failed');
        }

        return $token;
    }

    private static function getSegments(Config $config): array
    {
        $segments = explode('.', $config->getToken());

        if (count($segments) != 3) {
            throw new UnexpectedValueException('Wrong number of segments');
        }

        return $segments;
    }

    private static function generateToken(array $segments): Token
    {
        list($headerb64, $payloadb64, $signb64) = $segments;

        $header = static::json64($headerb64);

        if (is_null($header)) {
            throw new UnexpectedValueException('Invalid header encoding');
        }

        $payload = static::json64($payloadb64);

        if (is_null($payload)) {
            throw new UnexpectedValueException('Invalid payload encoding');
        }

        $sign = static::base64UrlSafe($signb64);

        if ($sign === false) {
            throw new UnexpectedValueException('Invalid sign encoding');
        }

        return new Token($segments, $header, $payload, $sign);
    }

    private static function json64(string $valueB64)
    {
        $value = static::base64UrlSafe($valueB64);

        return static::json($value);
    }

    private static function json(string $input)
    {
        return json_decode($input, false, 512, JSON_BIGINT_AS_STRING);
    }

    private static function base64UrlSafe($value): string
    {
        $remainder = strlen($value) % 4;

        if ($remainder) {
            $padlen = 4 - $remainder;
            $value .= str_repeat('=', $padlen);
        }

        $subject = strtr($value, '-_', '+/');

        return base64_decode($subject);
    }
}
