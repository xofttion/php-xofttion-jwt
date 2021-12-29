<?php

namespace Xofttion\JWT\Encode;

class Config
{
    // Atributos de la clase Config

    private $payload;

    private $key;

    private $method;

    private $id;

    private $headers;

    // Constructor de la clase Config

    public function __construct(array $payload, string $key, string $method = 'HMAC_SHA256')
    {
        $this->payload = $payload;
        $this->key = $key;
        $this->method = $method;
    }

    // Métodos de la clase Config

    public function getPayload(): array
    {
        return $this->payload;
    }

    public function getKey(): string
    {
        return $this->key;
    }

    public function getMethod(): string
    {
        return $this->method;
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
