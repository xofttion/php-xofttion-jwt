<?php

namespace Xofttion\JWT\Encode;

class Config
{
    // Atributos de la clase Config

    private array $payload;

    private string $key;

    private string $method;

    private ?string $id;

    private ?array $headers;

    // Constructor de la clase Config

    public function __construct(
        array $payload,
        string $key,
        string $method = 'HS256',
        ?string $id = null,
        ?array $headers = null
    ) {
        $this->payload = $payload;
        $this->key = $key;
        $this->method = $method;
        $this->id = $id;
        $this->headers = $headers;
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

    public function getId(): ?string
    {
        return $this->id;
    }

    public function getHeaders(): ?array
    {
        return $this->headers;
    }
}
