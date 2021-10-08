<?php
class DorayakiModel
{
    private $db;

    public function __construct(SQLite3 $db) {
        $this->db = $db;
    }

    public static function create_database(SQLite3 $db): void {
        $db->exec("
            CREATE TABLE IF NOT EXISTS Dorayakis(
                dorayaki_id INTEGER PRIMARY KEY,
                name TEXT,
                description TEXT,
                price INTEGER,
                stock INTEGER,
                thumbnail TEXT
            )
        ");
    }

}
