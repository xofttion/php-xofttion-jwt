<?php

namespace Xofttion\JWT\Encode;

use DomainException;
use Xofttion\JWT\Sign;

class Service
{
    public static function rfc7519(Config $config): string
    {
        $header = static::header($config);

        $payloadEncode = static::json64($config->getPayload());
        $headerEncode = static::json64($header);

        $segments = [];
        $segments[] = $headerEncode;
        $segments[] = $payloadEncode;

        $signValue = implode('.', $segments);
        $sign = Sign::generate($signValue, $config);

        $segments[] = static::base64UrlSafe($sign);

        return implode('.', $segments);
    }

    private static function header(Config $config): array
    {
        $header = [
            'typ' => 'JWT',
            'alg' => $config->getMethod()
        ];

        if (!is_null($config->getId())) {
            $header['kid'] = $config->getId();
        }

        if (!is_null($config->getHeaders())) {
            $header = array_merge($header, $config->getHeaders());
        }

        return $header;
    }

    private static function json64(?array $input): string
    {
        $encode = static::json($input);

        return static::base64UrlSafe($encode);
    }

    private static function json(?array $input): string
    {
        $encode = json_encode($input);

        if ($encode === 'null' && $input !== null) {
            throw new DomainException('Null result with non-null input');
        }

        return $encode;
    }

    private static function base64UrlSafe(string $input): string
    {
        $base64 = base64_encode($input);

        $subject = strtr($base64, '+/', '-_');

        return str_replace('=', '', $subject);
    }
}
