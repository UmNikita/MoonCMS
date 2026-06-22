<?php 

namespace Moon\infrastructure\User\Session;

use Moon\infrastructure\Database\Database;
use Moon\infrastructure\DI\ServiceContainer;
use Moon\infrastructure\User\Cookie;

class SessionStorage {

    public static function save(ServiceContainer $container): void {
        $session = $container->get(Session::class);
        if(!$session->isChange) {
            return;
        }
        $cookie = $container->get(Cookie::class);
        $body = $session->body();
        $json = json_encode($body);
        $base = base64_encode($json);
        $sessionId = $session->getSessionId();
        $cookie->set(Session::$keyName, $session->getSessionId());
        $sessionDb = new SessionDBGateway($container->get(Database::class));
        if($sessionDb->hasSession($sessionId))
            $sessionDb->changeSession($sessionId, $base);
        else
            $sessionDb->addSession($sessionId, $base);
    }

    public static function init(ServiceContainer $container): void {
        $session = $container->get(Session::class);
        $sessionDb = new SessionDBGateway($container->get(Database::class));
        $data = $sessionDb->getBody($session->getSessionId());
        if(!$data) {
            return;
        }
        $json = base64_decode($data);
        $body = json_decode($json, true);
        $session->setAll($body);
    }

    public static function checkSession(Database $db, string $id) {
        $sessionDb = new SessionDBGateway($db);
        return $sessionDb->hasSession($id);
    }

}