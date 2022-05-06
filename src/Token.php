<?php

namespace Xofttion\JWT;

use stdClass;

class Token
{
    private array $segments;

    private stdClass $header;

    private stdClass $payload;

    private string $sign;

    public function __construct(
        array $segments,
        stdClass $header,
        stdClass $payload,
        string $sign
    ) {
        $this->segments = $segments;
        $this->header = $header;
        $this->payload = $payload;
        $this->sign = $sign;
    }

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
