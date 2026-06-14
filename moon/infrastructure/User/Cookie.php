<?php 

namespace Moon\infrastructure\User;

class Cookie {

    private array $cookie;

    public function setCookie(array $cookie) {
        $this->cookie = $cookie;
    }

    public function get(string $key): string | null {
        if($this->cookie[$key])
            return $this->cookie[$key];
        else
            return null;
    }

    public function all(): array {
        return $this->cookie;
    }

    public function set(string $key, string $value) {
        $this->cookie[$key] = $value;
    }

}