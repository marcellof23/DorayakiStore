<?php

use Carbon\Carbon;

class OrderModel
{
    private $table = 'Orders';
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function getAllOrders()
    {
        $this->db->query('SELECT * FROM ' . $this->table);
        return $this->db->resultSet();
    }

    public function getOrderById($id)
    {
        $this->db->query('SELECT * FROM ' . $this->table . ' WHERE order_id=:id');
        $this->db->bind('order_id', $id);
        return $this->db->single();
    }

    public function createOrder($data)
    {
        $query = "INSERT INTO $table
                    VALUES
                  ('', '', '', :amount, :createdAt, :thumbnail)";

        $currentTime = Carbon::now();

        $this->db->query($query);
        $this->db->bind('amount', $data['amount']);
        $this->db->bind('createdAt', $currentTime);
        $this->db->bind('thumbnail', $data['thumbnail']);

        $this->db->execute();

        return $this->db->rowCount();
    }

    public function deleteOrder($id)
    {
        $query = "DELETE FROM  $table WHERE order_id = :id";

        $this->db->query($query);
        $this->db->bind('order_id', $id);

        $this->db->execute();

        return $this->db->rowCount();
    }

    public function updateOrder($data)
    {
        $query = "UPDATE $table SET
                    amount = :amount,
                    thumbnail = :thumbnail,
                  WHERE order_id = :id";

        $this->db->query($query);
        $this->db->bind('amount', $data['amount']);
        $this->db->bind('thumbnail', $data['thumbnail']);

        $this->db->execute();

        return $this->db->rowCount();
    }

    public static function createOrderDatabase(SQLite3 $db): void
    {
        $db->exec("
            CREATE TABLE IF NOT EXISTS $table (
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
