<?php
class UserModel
{
    public static $table = 'Users';
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function getAllUsers()
    {
        $this->db->query('SELECT * FROM ' . UserModel::$table);
        return $this->db->resultSet();
    }

    public function getUsers($page)
    {
        $limit = 20;
        $offset = ($page - 1) * $limit;

        $this->db->query('SELECT * FROM ' . UserModel::$table . " LIMIT " . $limit . " OFFSET " . $offset);
        return $this->db->resultSet();
    }

    public function getUserById($id)
    {
        $this->db->query('SELECT * FROM ' . UserModel::$table . ' WHERE user_id = :user_id');
        $this->db->bind(':user_id', $id);
        return $this->db->single();
    }

    public function getUserByEmail($email)
    {
        $this->db->query('SELECT * FROM ' . UserModel::$table . ' WHERE email = :email');
        $this->db->bind(':email', $$email);
        return $this->db->single();
    }

    public function getUserByUsername($username)
    {
        $this->db->query('SELECT * FROM ' . UserModel::$table . ' WHERE username = :username');
        $this->db->bind(':username', $username);
        return $this->db->single();
    }

    public function getUserId($username)
    {
        $this->db->query('SELECT user_id FROM ' . UserModel::$table . ' WHERE username = :username');
        $this->db->bind(':username', $username);
        return $this->db->single();
    }

    public function createUser($data)
    {
        $query = "
            INSERT INTO " . UserModel::$table . "
            VALUES
                (NULL, :name, :username, :email, :password, false)
        ";

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
                    email = :email
                    "
            . (isset($data["password"]) ? ",password = :password " : "") . "
                  WHERE user_id = :user_id";

        $this->db->query($query);

        $this->db->bind(':user_id', $data['user_id']);
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':username', $data['username']);
        $this->db->bind(':email', $data['email']);

        if (isset($data["password"])) {
            $this->db->bind(':password', $data['password']);
        }

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
                user_id INTEGER PRIMARY KEY,
                name TEXT,
                username TEXT NOT NULL UNIQUE,
                email TEXT NOT NULL UNIQUE,
                password TEXT,
                is_admin BOOL
            )
        ");
    }

}
