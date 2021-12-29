<?php

namespace Xofttion\JWT;

use stdClass;

class Token
{
    // Atributos de la clase Token

    private $segments;

    private $header;

    private $payload;

    private $sign;

    // Constructor de la clase Token

    public function __construct(array $segments, stdClass $header, stdClass $payload, string $sign)
    {
        $this->segments = $segments;
        $this->header = $header;
        $this->payload = $payload;
        $this->sign = $sign;
    }

    // Métodos de la clase Token

    public function getSegments(): array
    {
        return $this->segments;
    }

    public function getHeader(): stdClass
    {
        return $this->header;
    }

    public function getPayload(): stdClass
    {
        return $this->payload;
    }

    public function getSign(): string
    {
        return $this->sign;
    }
}
