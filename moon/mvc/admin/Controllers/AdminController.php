<?php

use Moon\infrastructure\Http\Response;

class AdminController {
    public function index() {
        return new Response(template: 'admin');
    }
}