<?php 

namespace Moon\infrastructure\User;

class UserDTO {
    public function __construct(
        private string $name,
        private string $email,
        private string $password,
        private string | null $remember_token = null,
        private int | null $id = null
    ) {}

    public function getId(): int { return $this->id; }
    public function getName(): string { return $this->name; }
    public function getEmail(): string { return $this->email; }
    public function getPassword(): string { return $this->password; }
    public function getRememberToken(): string { return $this->remember_token; }

    public function setId(int $id) { $this->id = $id; }
    public function setName(string $name) { $this->name = $name;}
    public function setEmail(string $email) { $this->email = $email; }
    public function setPassword(string $password) { $this->password = $password; }
    public function setRememberToken(string $token) { $this->remember_token = $token; }
    
}