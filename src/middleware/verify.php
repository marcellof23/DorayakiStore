<?php

require_once '../../config/constant.php';
require_once ROOT . '/controllers/user.php';
require_once ROOT . '/config/db.php';
require_once ROOT . '/models/user.php';

class Middleware
{
    private $db;
    private $userModel;

    public function __construct()
    {
        $this->db = new Database();
        $this->userModel = new UserModel($this->db);
    }

    public function verify()
    {
    }
}
