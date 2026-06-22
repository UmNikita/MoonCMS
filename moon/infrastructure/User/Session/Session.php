<?php 

namespace Moon\infrastructure\User\Session;

use Moon\infrastructure\User\Cookie;

class Session {

    private string $sessionId;
    private array $body;
    private bool $hasSession = false;
    public static string $keyName = "sessionID";
    public bool $isChange = false;

    public function __construct(Cookie $cookie)
    {
        $cookieValue = $cookie->get(self::$keyName);
        if($cookieValue) {
            $this->sessionId = $cookieValue;
            $this->hasSession = true;
        }   
        else
            $this->sessionId = bin2hex(random_bytes(32));
    }

    public function set(string $key, string $value) {
        $this->isChange = true;
        $this->body[$key] = $value;
    }

    public function get(string $key) {
        return $this->body[$key] ?? null;
    }

    public function setAll(array $body) {
        $this->body = $body;
    }

    public function body() {
        return $this->body ?? [];
    }

    public function getSessionId(): string {
        return $this->sessionId;
    }

    public function hasSession(): bool { return $this->hasSession; }
}