<?php
class OrderModel
{
    public static $table = 'Orders';
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function getAllOrders()
    {
        $this->db->query('SELECT * FROM ' . OrderModel::$table);
        return $this->db->resultSet();
    }

    public function getOrderById($id)
    {
        $this->db->query('SELECT * FROM ' . OrderModel::$table . ' WHERE order_id = :order_id');
        $this->db->bind(':order_id', $id);
        return $this->db->single();
    }

    public function createOrder($data)
    {
        $query = "INSERT INTO " . OrderModel:: $table . " VALUES
                  (NULL, :user_id, :doriyaki_id, :amount, :createdAt, :thumbnail)";

        $dt = new DateTime();

        $this->db->query($query);

        $this->db->bind(':user_id', $data['user_id']);
        $this->db->bind(':doriyaki_id', $data['doriyaki_id']);
        $this->db->bind(':amount', $data['amount']);
        $this->db->bind(':createdAt', $dt->format('Y-m-d H:i:s'));
        $this->db->bind(':thumbnail', $data['thumbnail']);

        $this->db->execute();

        return $this->db->rowCount();
    }

    public function deleteOrder($id)
    {
        $query = "DELETE FROM " . OrderModel::$table . " WHERE order_id = :order_id";

        $this->db->query($query);

        $this->db->bind(':order_id', $id);

        $this->db->execute();

        return $this->db->rowCount();
    }

    public function updateOrder($data)
    {
        $query = "UPDATE " . OrderModel::$table . " SET
                    amount = :amount,
                    thumbnail = :thumbnail
                  WHERE order_id = :order_id";

        $this->db->query($query);

        $this->db->bind(':order_id', $data['order_id']);
        $this->db->bind(':amount', $data['amount']);
        $this->db->bind(':thumbnail', $data['thumbnail']);

        $this->db->execute();

        return $this->db->rowCount();
    }

    public static function createOrderDatabase(SQLite3 $db): void
    {
        $db->exec("
            CREATE TABLE IF NOT EXISTS " . OrderModel::$table . "(
                order_id INTEGER NOT NULL,
                user_id INTEGER NOT NULL,
                doriyaki_id INTEGER NOT NULL,
                amount INTEGER,
                createdAt TEXT,
                type TEXT CHECK(type IN ('ADD', 'MIN')),
                PRIMARY KEY (order_id),
                FOREIGN KEY (user_id) REFERENCES User(user_id),
                FOREIGN KEY (doriyaki_id) REFERENCES Doriyaki(doriyaki_id)
            )
        ");
    }

}