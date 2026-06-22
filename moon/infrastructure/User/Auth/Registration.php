<?php 

namespace Moon\infrastructure\User\Auth;

use Moon\infrastructure\User\UserDBGateway;
use Moon\infrastructure\User\UserDTO;

class Registration {

    private UserDBGateway $gateway;

    public function __construct(UserDBGateway $gateway)
    {
        $this->gateway = $gateway;
    }

    public function register(UserDTO $user) {
        $hash = $this->hashPassword($user->getPassword());
        $user->setPassword($hash);
        if(!$this->isUserExist($user))
            $this->gateway->addUser($user);
    }

    private function isUserExist(UserDTO $user) {
        $email = $user->getEmail();
        return $this->gateway->emailExist($email);
    }

    private function hashPassword(string $psw) {
        return password_hash($psw, PASSWORD_BCRYPT);
    }

}