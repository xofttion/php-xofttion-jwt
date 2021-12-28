<?php

namespace Xofttion\JWT\Encode;

class Config
{
    private $payload;

    private $key;

    private $alg;

    private $id;

    private $headers;

    public function __construct(array $payload, string $key, string $alg = 'HS256')
    {
        $this->payload = $payload;
        $this->key = $key;
        $this->alg = $alg;
    }

    public function getPayload(): array
    {
        return $this->payload;
    }

    public function getKey(): string
    {
        return $this->key;
    }

    public function getAlg(): string
    {
        return $this->alg;
    }

    public function setId(?string $id): void
    {
        $this->id = $id;
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    public function setHeaders(?array $headers): void
    {
        $this->headers = $headers;
    }

    public function getHeaders(): ?array
    {
        return $this->headers;
    }
}
