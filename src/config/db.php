<?php

class Database
{
    private static $dbInstance;
    private $db_engine = "sqlite:";
    private $db_file = "db/dorayaki.db";
    private $db;
    private $statement;

    public static function getInstance()
    {
        if (is_null(Database::$dbInstance)) {
            self::$dbInstance = new Database();
        }

        return self::$dbInstance;
    }

    public function __construct()
    {
        try {
            $this->db = new PDO($this->db_engine . $this->db_file . "");
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->db->setAttribute(PDO::ATTR_EMULATE_PREPARES, true);

            $stm = $this->db->query("SELECT * FROM Users");
            $rows = $stm->fetchAll(PDO::FETCH_NUM);

            foreach ($rows as $row) {
                echo ("$row[0] $row[1] $row[2] $row[3] $row[4] $row[5]\n");
            }
        } catch (PDOException $pdo) {
            echo "Database not found!";
        }
    }

    public function getDb()
    {
        return $this->db;
    }

    public function query($query)
    {
        $this->query = $this->db->prepare($query);
    }

    public function bind($param, $value, $type = null)
    {
        if (is_null($type)) {
            switch (true) {
                case is_int($value):
                    $type = PDO::PARAM_INT;
                    break;
                case is_bool($value):
                    $type = PDO::PARAM_BOOL;
                    break;
                case is_null($value):
                    $type = PDO::PARAM_NULL;
                    break;
                default:
                    $type = PDO::PARAM_STR;
            }
        }

        $this->statement->bindValue($param, $value, $type);
    }

    public function execute()
    {
        $this->statement->execute();
    }

    public function resultSet()
    {
        $this->execute();
        return $this->statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function single()
    {
        $this->execute();
        return $this->statement->fetch(PDO::FETCH_ASSOC);
    }

    public function rowCount()
    {
        return $this->statement->rowCount();
    }
}
