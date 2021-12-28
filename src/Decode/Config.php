<?php

namespace Xofttion\JWT\Decode;

class Config
{
    private $token;

    private $key;

    public function __construct(string $token, string $key)
    {
        $this->token = $token;
        $this->key = $key;
    }

    public function getToken(): string
    {
        return $this->token;
    }

    public function getKey(): string
    {
        return $this->key;
    }
}
