<?php
class UserModel
{
    private $table = 'Users';
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function getAllUsers()
    {
        $this->db->query('SELECT * FROM ' . $this->table);
        return $this->db->resultSet();
    }

    public function getUserById($id)
    {
        $this->db->query('SELECT * FROM ' . $this->table . ' WHERE user_id=:id');
        $this->db->bind('user_id', $id);
        return $this->db->single();
    }

    public function createUser($data)
    {
        $query = "INSERT INTO $table
                    VALUES
                  ('', :name, :username, :email, :email, :password, :is_admin)";

        $currentTime = Carbon::now();

        $this->db->query($query);
        $this->db->bind('name', $data['name']);
        $this->db->bind('username', $data['username']);
        $this->db->bind('email', $data['email']);
        $this->db->bind('password', $data['password']);
        $this->db->bind('is_admin', $data['is_admin']);

        $this->db->execute();

        return $this->db->rowCount();
    }

    public function deleteUser($id)
    {
        $query = "DELETE FROM  $table WHERE user_id = :id";

        $this->db->query($query);
        $this->db->bind('user_id', $id);

        $this->db->execute();

        return $this->db->rowCount();
    }

    public function updateUser($data)
    {
        $query = "UPDATE $table SET
                    amount = :amount,
                    thumbnail = :thumbnail,
                  WHERE user_id = :id";

        $this->db->query($query);
        $this->db->bind('name', $data['name']);
        $this->db->bind('username', $data['username']);
        $this->db->bind('email', $data['email']);
        $this->db->bind('password', $data['password']);
        $this->db->bind('is_admin', $data['is_admin']);

        $this->db->execute();

        return $this->db->rowCount();
    }

    public static function createUserDatabase(SQLite3 $db): void
    {
        $create_user = "
            CREATE TABLE IF NOT EXISTS $table (
                user_id INTEGER PRIMARY KEY,
                name TEXT,
                username TEXT,
                email TEXT,
                password TEXT,
                is_admin BOOL
            )
        ";
        $db->exec($create_user);
    }

}
