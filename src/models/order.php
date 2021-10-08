<?php
class OrderModel
{
    private $db;

    public function __construct(SQLite3 $db) {
        $this->db = $db;
    }

    public static function create_database(SQLite3 $db): void {
        $db->exec("
            CREATE TABLE IF NOT EXISTS Orders(
                order_id INTEGER NOT NULL,
                user_id INTEGER NOT NULL,
                doriyaki_id INTEGER NOT NULL,
                amount INTEGER,
                createdAt TEXT,
                thumbnail TEXT,
                PRIMARY KEY (order_id),
                FOREIGN KEY (user_id) REFERENCES User(user_id),
                FOREIGN KEY (doriyaki_id) REFERENCES Doriyaki(doriyaki_id)
            )
        ");
    }

}
