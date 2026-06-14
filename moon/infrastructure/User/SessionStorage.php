<?php 

namespace Moon\infrastructure\User;

use Moon\infrastructure\Database\Database;
use Moon\infrastructure\DI\ServiceContainer;

class SessionStorage {

    public static function save(ServiceContainer $container): void {
        $session = $container->get(Session::class);
        if(!$session->isChange) {
            return;
        }
        $cookie = $container->get(Cookie::class);
        $db = $container->get(Database::class);
        $body = $session->body();
        $json = json_encode($body);
        $base = base64_encode($json);
        $sessionId = $session->getSessionId();
        $cookie->set(Session::$keyName, $session->getSessionId());
        $db->query("INSERT INTO sessions (session_id, body) VALUES (:session_id, :body)", [":session_id" => $sessionId, ":body" => $base]);
    }

    public static function init(ServiceContainer $container): void {
        $session = $container->get(Session::class);
        $db = $container->get(Database::class);
        $dbData = $db->query("SELECT body FROM sessions WHERE session_id = :session_id", [":session_id" => $session->getSessionId()]);
        $data = $dbData->fetchAll()[0]['body'];
        if(!$data) {
            return;
        }
        $json = base64_decode($data);
        $body = json_decode($json, true);
        $session->setAll($body);
    }
}