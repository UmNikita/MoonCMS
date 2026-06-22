<?php 

namespace Moon\infrastructure\User;

use Moon\infrastructure\Database\Database;
use Moon\infrastructure\User\UserDTO;

class UserDBGateway {

    private Database $db;

    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    public function getUserByEmail(string $email): UserDTO | null {
        $user = new UserDTO("nikita", "nik@mail.ru", "psw");
        $dbData = $this->db->query('SELECT * FROM "user" WHERE email = :email', [":email" => $email])->fetchAll();
        if(count($dbData) == 0) {
            return null;
        }
        $data = $dbData[0];
        $user = new UserDTO($data['name'], $data['email'], $data['password']);
        $user->setId($data['id']);
        return $user;
    }

    public function addUser(UserDTO $user) {
        $name = $user->getName();
        $email = $user->getEmail();
        $password = $user->getPassword();
        $this->db->query('INSERT INTO "user" (name, email, password) VALUES (:name, :email, :password)', [":name" => $name, ":email" => $email, ":password" => $password]);
    }
    
    public function emailExist(string $email): bool {
        $dbData = $this->db->query('SELECT id FROM "user" WHERE email = :email', [":email" => $email]);
        $data = $dbData->fetchAll();
        if(count($data) > 0)
            return true;
        else
            return false;
    }
}