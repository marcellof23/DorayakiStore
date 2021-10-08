<?php
class UserModel
{
    private $db;

    public function __construct(SQLite3 $db) {
        $this->db = $db;
    }

    public static function create_database(SQLite3 $db): void {
        $db->exec("
            CREATE TABLE IF NOT EXISTS Users(
                user_id INTEGER PRIMARY KEY,
                name TEXT,
                username TEXT,
                email TEXT,
                password TEXT,
                is_admin BOOL
            )
        ");
    }

    // public function register(string $name, string $email, string $password): bool
    // {
    //     return $this->model->insert([
    //         'name' => $name,
    //         'email' => $email,
    //         'password' => $password,
    //         "status" => 0,
    //         "date_created" => date("Y-m-d H:i:s"),
    //     ]);
    // }

    // public function verifyLogin(string $email, string $password): bool
    // {
    //     return $this->model->hasOne([
    //         'email' => $email,
    //         'password' => $password,
    //     ]);
    // }

}
