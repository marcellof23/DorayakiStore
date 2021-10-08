<?php

include "../config/db.php";

class DorayakiModel
{
    private $table = 'Dorayakis';
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public static function createDorayakiDatabase(SQLite3 $db): void
    {
        $db->exec("
            CREATE TABLE IF NOT EXISTS $table (
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
