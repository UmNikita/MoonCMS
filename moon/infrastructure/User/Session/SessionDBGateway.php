<?php 

namespace Moon\infrastructure\User\Session;

use Moon\infrastructure\Database\Database;
use Moon\infrastructure\DI\ServiceContainer;

class SessionDBGateway {

    private Database $db;

    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    public function addSession(string $sessionId, string $body) {
        $this->db->query("INSERT INTO session (session_id, body) VALUES (:session_id, :body)", [":session_id" => $sessionId, ":body" => $body]);
    }

    public function changeSession(string $sessionId, string $body) {
        $this->db->query("UPDATE session set body = :body WHERE session_id = :session_id", [":session_id" => $sessionId, ":body" => $body]);
    }

    public function hasSession(string $sessionId): bool {
        $dbData = $this->db->query("SELECT body FROM session WHERE session_id = :session_id", [":session_id" => $sessionId]);
        $data = $dbData->fetchAll();
        if(count($data) > 0)
            return true;
        else
            return false;  
    }

    public function getBody(string $sessionId) {
        $dbData = $this->db->query("SELECT body FROM session WHERE session_id = :session_id", [":session_id" => $sessionId]);
        $data = $dbData->fetchAll()[0]['body'];
        return $data;    
    }

}