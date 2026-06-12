<?php

namespace Moon\infrastructure\Database\Migration;

interface Migration {
    
    public function up();
    public function down();

}