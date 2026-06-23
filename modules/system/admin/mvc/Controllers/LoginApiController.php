<?php

use Moon\infrastructure\Http\Request;
use Moon\infrastructure\Http\Response;
use Moon\infrastructure\Http\RestController;
use Moon\infrastructure\User\Auth\Login;

class LoginApiController extends RestController {

    private Login $login;
    
    public function __construct(Request $request, Response $response, Login $login)
    {
        $this->login = $login;
        parent::__construct($request, $response);
    }

    public function login() {
        $body = $this->request->getBody();
        $email = $body['email'];
        $password = $body['password'];
        $isLogin = $this->login->login($email, $password);
        if($isLogin)
            $res = ["success" => true];
        else
            $res = ["success" => false];
        return $this->response($res);
    }
}