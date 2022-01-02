<?php

namespace Xofttion\JWT\Decode;

class Config
{
    // Atributos de la clase Config

    private string $token;

    private string $key;

    // Constructor de la clase Config

    public function __construct(string $token, string $key)
    {
        $this->token = $token;
        $this->key = $key;
    }

    // Métodos de la clase Config

    public function getToken(): string
    {
        return $this->token;
    }

    public function getKey(): string
    {
        return $this->key;
    }
}
