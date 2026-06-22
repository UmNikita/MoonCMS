<?php 

namespace Moon\infrastructure\User\Auth;

use Moon\infrastructure\Database\Database;
use Moon\infrastructure\User\Session\Session;
use Moon\infrastructure\User\Session\SessionStorage;
use Moon\infrastructure\User\UserDBGateway;

class Login {

    private UserDBGateway $gateway;
    private Session $session;
    private Database $db;

    public function __construct(Database $db, UserDBGateway $gateway, Session $session)
    {
        $this->db = $db;
        $this->gateway = $gateway;
        $this->session = $session;
    }

    public function login(string $email, string $psw): bool {
        $user = $this->gateway->getUserByEmail($email);
        if($user) {
            if($this->checkPassword($psw, $user->getPassword())) {
                $this->session->set("user_id", $user->getId());
                return true;
            }
            else {
                return false;
            }
        }
        else
            return false;
    }

    public function auth(): bool {
        if(!$this->session->hasSession()) {
            return false;
        }
        $id = $this->session->getSessionId();
        return SessionStorage::checkSession($this->db, $id);
    }

    private function checkPassword(string $pswUser, string $pswDB): bool {
        return password_verify($pswUser, $pswDB);
    }
}