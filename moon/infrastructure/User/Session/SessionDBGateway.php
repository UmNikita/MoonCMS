<?php 

namespace Moon\infrastructure\User\Session;

use Moon\infrastructure\Database\Database;
use Moon\infrastructure\DI\ServiceContainer;

class SessionDBGateway {

    private Database $db;

    public function __construct(ServiceContainer $container)
    {
        $this->db = $container->get(Database::class);
    }

    public function addSession(string $sessionId, string $body) {
        $this->db->query("INSERT INTO session (session_id, body) VALUES (:session_id, :body)", [":session_id" => $sessionId, ":body" => $body]);
    }

    public function getBody(string $sessionId) {
        $dbData = $this->db->query("SELECT body FROM session WHERE session_id = :session_id", [":session_id" => $sessionId]);
        $data = $dbData->fetchAll()[0]['body'];
        return $data;    
    }

}