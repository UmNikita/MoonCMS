<?php

namespace Moon\infrastructure\Http;

class Headers {

    private array $headers = [];
    
    public function __construct(array $headers = [])
    {
        $this->headers = $headers;
    }
    
    public function set(string $name, string $value): self
    {
        $this->headers[$name] = $value;
        return $this;
    }
    
    public function get(string $name, ?string $default = null): ?string
    {
        return $this->headers[$name] ?? $default;
    }
    
    public function send(): void
    {
        foreach ($this->headers as $name => $value) {
            header("$name: $value");
        }
    }
}