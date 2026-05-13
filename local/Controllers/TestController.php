<?php

use Moon\infrastructure\Http\Response;

class TestController {
    public function test() {
        return new Response(template: 'layout');
    }
}