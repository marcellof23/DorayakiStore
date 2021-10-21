<?php
class OrderModel
{
    public static $table = 'Orders';
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function getAllOrders()
    {
        $this->db->query('SELECT * FROM ' . OrderModel::$table);
        return $this->db->resultSet();
    }

    public function getOrders($page, $isOrder)
    {
        $limit = 10;
        $offset = ($page - 1) * $limit;

        $selection = "O.*, D.name AS dorayaki, U.name AS user";
        $join = "INNER JOIN " . DorayakiModel::$table . " D ON D.dorayaki_id = O.dorayaki_id INNER JOIN " . UserModel::$table . " U on U.user_id = O.user_id";
        $pagination = "LIMIT " . $limit . " OFFSET " . $offset;
        $query = 'SELECT ' . $selection . ' FROM ' . OrderModel::$table . " O " . $join . " WHERE isOrder = " . $isOrder . " " . $pagination;

        $this->db->query($query);
        return $this->db->resultSet();
    }

    public function countOrders($isOrder)
    {
        $where = 'isOrder = ' . $isOrder;
        $query = 'SELECT COUNT(order_id) as total_order FROM ' . OrderModel::$table . ' WHERE ' . $where;
        $this->db->query($query);
        return $this->db->resultSet();
    }

    public function countOrderByUserId($user_id)
    {
        $where = 'user_id = ' . $user_id;
        $query = 'SELECT COUNT(order_id) as total_order FROM ' . OrderModel::$table . ' WHERE ' . $where;
        $this->db->query($query);
        return $this->db->resultSet();
    }

    public function getOrderById($id)
    {
        $join = "INNER JOIN " . DorayakiModel::$table . " D ON D.dorayaki_id = O.dorayaki_id INNER JOIN " . UserModel::$table . " U on U.user_id = O.user_id";
        $this->db->query('SELECT * FROM ' . OrderModel::$table . ' O ' . $join . ' WHERE O.order_id = :order_id');
        $this->db->bind(':order_id', $id);
        return $this->db->single();
    }

    public function getOrderByUserId($page, $user_id)
    {
        $limit = 10;
        $offset = ($page - 1) * $limit;

        $selection = "O.*, D.name AS dorayaki, U.name AS user";
        $join = "INNER JOIN " . DorayakiModel::$table . " D ON D.dorayaki_id = O.dorayaki_id INNER JOIN " . UserModel::$table . " U on U.user_id = O.user_id";
        $pagination = "LIMIT " . $limit . " OFFSET " . $offset;
        $this->db->query('SELECT ' . $selection . ' FROM ' . OrderModel::$table . " O " . $join . " WHERE O.user_id = " . $user_id . " " . $pagination);
        return $this->db->resultSet();
    }

    public function createOrder($data)
    {
        $query = "INSERT INTO " . OrderModel::$table . " VALUES
                  (NULL, :user_id, :dorayaki_id, :amount, :total_cost, :isOrder, :createdAt, :type)";

        $dt = new DateTime();

        $this->db->query($query);

        $this->db->bind(':user_id', $data['user_id']);
        $this->db->bind(':dorayaki_id', $data['dorayaki_id']);
        $this->db->bind(':amount', $data['amount']);
        $this->db->bind(':total_cost', (int) $data['amount'] * (int) $data["price"]);
        $this->db->bind(':isOrder', $data['isOrder']);
        $this->db->bind(':createdAt', $dt->format('Y-m-d H:i:s'));
        $this->db->bind(':type', $data['type']);

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
                    isOrder = :isOrder,
                    type = :type,
                  WHERE order_id = :order_id";

        $this->db->query($query);

        $this->db->bind(':order_id', $data['order_id']);
        $this->db->bind(':amount', $data['amount']);
        $this->db->bind(':isOrder', $data['isOrder']);
        $this->db->bind(':type', $data['type']);

        $this->db->execute();

        return $this->db->rowCount();
    }

    public static function createOrderDatabase(SQLite3 $db): void
    {
        $db->exec("
            CREATE TABLE IF NOT EXISTS " . OrderModel::$table . "(
                order_id INTEGER NOT NULL,
                user_id INTEGER NOT NULL,
                dorayaki_id INTEGER NOT NULL,
                amount INTEGER,
                total_cost INTEGER,
                isOrder BIT,
                createdAt TEXT,
                type TEXT CHECK(type IN ('ADD', 'MIN')),
                PRIMARY KEY (order_id),
                FOREIGN KEY (user_id) REFERENCES Users(user_id),
                FOREIGN KEY (dorayaki_id) REFERENCES Dorayakis(dorayaki_id)
            )
        ");
    }

}
