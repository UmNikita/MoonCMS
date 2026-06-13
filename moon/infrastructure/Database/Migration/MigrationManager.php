<?php

namespace Moon\infrastructure\Database\Migration;

class MigrationManager {

    private Schema $schema;

    public function __construct(Schema $schema)
    {
        $this->schema = $schema;
    }

    public function initMigrations() {
        $table = $this->schema->table("migrations");
        $table->id();
        $table->string("migration");
        $table->int("batch");
        $table->create();
    }
}