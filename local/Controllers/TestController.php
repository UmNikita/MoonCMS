<?php

use Moon\infrastructure\Http\Controller;

class TestController extends Controller {
    
    public function test() {
        return $this->show('layout');
    }
}