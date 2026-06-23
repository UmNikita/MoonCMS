<?php

use Moon\infrastructure\Http\Controller;

class LoginController extends Controller {
    public function index() {
        return $this->show('login');
    }
}