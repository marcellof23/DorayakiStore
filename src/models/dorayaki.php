<?php
class DorayakiModel
{
    public static $table = 'Dorayakis';
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function getAllDoriyakis()
    {
        $this->db->query('SELECT * FROM ' . DorayakiModel::$table);
        return $this->db->resultSet();
    }

    public function getDoriyakis($page)
    {
        $limit = 20;
        $offset = ($page - 1) * $limit;

        $this->db->query('SELECT * FROM ' . DorayakiModel::$table . "LIMIT " . $limit . " OFFSET " . $offset);
        return $this->db->resultSet();
    }

    public function getDoriyakiById($id)
    {
        $this->db->query('SELECT * FROM ' . DorayakiModel::$table . ' WHERE dorayaki_id = :dorayaki_id');
        $this->db->bind(':dorayaki_id', $id);
        return $this->db->single();
    }

    public function createDoriyaki($data)
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

    public function deleteDoriyaki($id)
    {
        $query = "DELETE FROM " . DorayakiModel::$table . " WHERE dorayaki_id = :dorayaki_id";

        $this->db->query($query);
        $this->db->bind(':user_id', $id);

        $this->db->execute();

        return $this->db->rowCount();
    }

    public function updateDoriyaki($data)
    {
        $query = "UPDATE " . DorayakiModel::$table . " SET
                    name = :name,
                    description = :description,
                    price = :price,
                    thumbnail = :thumbnail
                  WHERE doriyaki_id = :doriyaki_id";

        $this->db->query($query);

        $this->db->bind(':doriyaki_id', $data['doriyaki_id']);
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
                  WHERE doriyaki_id = :doriyaki_id";

        $this->db->query($query);

        $this->db->bind(':doriyaki_id', $data['doriyaki_id']);
        $this->db->bind(':stock', $data['stock']);

        $this->db->execute();

        return $this->db->rowCount();
    }

    public static function createDorayakiDatabase(SQLite3 $db): void
    {
        $db->exec("
            CREATE TABLE IF NOT EXISTS " . DorayakiModel::$table . "(
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
