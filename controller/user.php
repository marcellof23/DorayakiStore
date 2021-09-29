<?php
require 'model/user.php';
require_once 'config.php';

session_status() === PHP_SESSION_ACTIVE ? true : session_start();

class userController
{

    public function __construct()
    {
    }

    // mvc handler request
    public function mvcHandler()
    {
        $act = isset($_GET['act']) ? $_GET['act'] : null;
        switch ($act) {
            case 'add':
                $this->insert();
                break;
            case 'update':
                $this->update();
                break;
            case 'delete':
                $this->delete();
                break;
            default:
                $this->list();
        }
    }
    // page redirection
    public function pageRedirect($url)
    {
        header('Location:' . $url);
    }
    // check validation
    public function checkValidation($sporttb)
    {
    }
    // add new record
    public function insert()
    {
    }
    // update record
    public function update()
    {
    }
    // delete record
    public function delete()
    {
    }
}
