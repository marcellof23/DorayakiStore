<?php
class UserModel
{
    public static $table = 'Users';
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function getAllUsers()
    {
        $this->db->query('SELECT * FROM ' . UserModel::$table);
        return $this->db->resultSet();
    }

    public function getUserById($id)
    {
        $this->db->query('SELECT * FROM ' . UserModel::$table . ' WHERE user_id = :user_id');
        $this->db->bind(':user_id', $id);
        return $this->db->single();
    }

    public function createUser($data)
    {
        $query = "INSERT INTO " . UserModel::$table . " VALUES
                  (NULL, :name, :username, :email, :password, false)";

        $this->db->query($query);

        $this->db->bind(':name', $data['name']);
        $this->db->bind(':username', $data['username']);
        $this->db->bind(':email', $data['email']);
        $this->db->bind(':password', $data['password']);

        $this->db->execute();

        return $this->db->rowCount();
    }

    public function deleteUser($id)
    {
        $query = "DELETE FROM " . UserModel::$table . " WHERE user_id = :user_id";

        $this->db->query($query);
        $this->db->bind(':user_id', $id);

        $this->db->execute();

        return $this->db->rowCount();
    }

    public function updateUser($data)
    {
        $query = "UPDATE " . UserModel::$table . " SET
                    name = :name,
                    username = :username,
                    email = :email,
                    password = :password
                  WHERE user_id = :user_id";

        $this->db->query($query);

        $this->db->bind(':user_id', $data['user_id']);
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':username', $data['username']);
        $this->db->bind(':email', $data['email']);
        $this->db->bind(':password', $data['password']);

        $this->db->execute();

        return $this->db->rowCount();
    }

    public function updateAdmin($data)
    {
        $query = "UPDATE " . UserModel::$table . " SET
                    is_admin = :is_admin
                  WHERE user_id = :user_id";

        $this->db->query($query);

        $this->db->bind(':user_id', $data['user_id']);
        $this->db->bind(':is_admin', $data['is_admin']);

        $this->db->execute();

        return $this->db->rowCount();
    }

    public static function createUserDatabase(SQLite3 $db): void
    {
        $db->exec("
            CREATE TABLE IF NOT EXISTS " . UserModel::$table . "(
                user_id INTEGER AUTO_INCREMENT PRIMARY KEY,
                name TEXT,
                username TEXT,
                email TEXT,
                password TEXT,
                is_admin BOOL
            )
        ");
    }

}
