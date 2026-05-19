<?php

use Moon\infrastructure\Http\Controller;

class AdminController extends Controller {
    public function index() {
        return $this->show('admin');
    }
}