<?php
class DorayakiModel
{
    public static $table = 'Dorayakis';
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function getAllDorayakis()
    {
        $this->db->query('SELECT * FROM ' . DorayakiModel::$table);
        return $this->db->resultSet();
    }

    public function countDorayakis()
    {
        $this->db->query('SELECT COUNT(dorayaki_id) as total_dorayaki FROM ' . DorayakiModel::$table);
        return $this->db->resultSet();
    }

    public function getDorayakis($page)
    {
        $limit = 10;
        $offset = ($page - 1) * $limit;
        $this->db->query('SELECT * FROM ' . DorayakiModel::$table .
            " LIMIT " . $limit . " OFFSET " . $offset);
        return $this->db->resultSet();
    }

    public function getDorayakiPopularVariant()
    {
        $limit = 5;
        $selection = "D.*, COUNT(O.order_id) as sold_count";
        $join = "Orders O ON O.dorayaki_id = D.dorayaki_id";
        $from = "Dorayakis D INNER JOIN";
        $group_by = "D.dorayaki_id ORDER BY sold_count DESC LIMIT " . $limit;
        $this->db->query('SELECT ' . $selection . ' FROM ' . $from . ' ' . $join .
            ' GROUP BY ' . $group_by);

        return $this->db->resultSet();
    }

    public function getDorayakiById($id)
    {
        $this->db->query('SELECT * FROM ' . DorayakiModel::$table .
            ' WHERE dorayaki_id = :dorayaki_id');
        $this->db->bind(':dorayaki_id', $id);
        return $this->db->single();
    }

    public function createDorayaki($data)
    {
        $query = "INSERT INTO " . DorayakiModel::$table . " VALUES
                  (NULL, :name, :description, :price, :stock, :thumbnail)";

        $this->db->query($query);

        $this->db->bind(':name', $data['name']);
        $this->db->bind(':description', $data['description']);
        $this->db->bind(':price', $data['price']);
        $this->db->bind(':stock', $data['stock']);
        $this->db->bind(':thumbnail', $data['thumbnail']);

        $this->db->execute();

        return $this->db->rowCount();
    }

    public function deleteDorayaki($id)
    {
        $query = "DELETE FROM " . DorayakiModel::$table . " WHERE dorayaki_id = :dorayaki_id";

        $this->db->query($query);
        $this->db->bind(':dorayaki_id', $id);

        $this->db->execute();

        return $this->db->rowCount();
    }

    public function updateDorayaki($data)
    {
        $query = "UPDATE " . DorayakiModel::$table . " SET
                    name = :name,
                    description = :description,
                    price = :price,
                    thumbnail = :thumbnail
                  WHERE dorayaki_id = :dorayaki_id";

        $this->db->query($query);

        $this->db->bind(':dorayaki_id', $data['dorayaki_id']);
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':description', $data['description']);
        $this->db->bind(':price', $data['price']);
        $this->db->bind(':thumbnail', $data['thumbnail']);

        $this->db->execute();

        return $this->db->rowCount();
    }

    public function updateStock($data)
    {
        $query = "UPDATE " . DorayakiModel::$table . " SET
                    stock = :stock
                  WHERE dorayaki_id = :dorayaki_id";

        $this->db->query($query);

        $this->db->bind(':dorayaki_id', $data['dorayaki_id']);
        $this->db->bind(':stock', $data['stock']);

        $this->db->execute();

        return $this->db->rowCount();
    }

    public static function createDorayakiDatabase(SQLite3 $db): void
    {
        $db->exec("
            CREATE TABLE IF NOT EXISTS " . DorayakiModel::$table . "(
                dorayaki_id INTEGER PRIMARY KEY,
                name TEXT UNIQUE,
                description TEXT,
                price INTEGER,
                stock INTEGER,
                thumbnail TEXT
            )
        ");
    }
}
