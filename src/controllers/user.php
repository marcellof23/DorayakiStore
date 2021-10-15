<?php

require_once ROOT . '/config/db.php';
require_once ROOT . '/models/user.php';

class UserController
{
    private $db;
    private $userModel;

    public function __construct()
    {
        $this->db = new Database();
        $this->userModel = new UserModel($this->db);

        $lifetime = 3600;
        session_set_cookie_params($lifetime);
        session_start();
    }

    public function generateToken()
    {
        $token = bin2hex(random_bytes(16));
        return $token;
    }

    public function destructToken($token)
    {

    }

    public function login()
    {
        if (isset($_SESSION["login"])) {
            echo 'Already logged in';
            return;
        }

        if ($_POST["username"] == '' && $_POST["password"] == '') {
            echo 'Incomplete data';
            return;
        }

        $user = $this->userModel->getUserByUsername($_POST["username"]);

        print($user);

        if (isset($user)) {
            if (password_verify($_POST["password"], $user["password"])) {
                $token = $this->generateToken();

                $_SESSION["login"] = true;
                $_SESSION["user_id"] = $user["user_id"];
                $_SESSION["access_token"] = $token;

                setcookie("access_token", $token, time() + 3600, '/');

                header("Location: ../index.php");
            } else {
                echo 'Wrong password';
            }
        } else {
            echo 'User not found';
        }
    }

    public function register()
    {
        if (isset($_SESSION["login"])) {
            echo 'Already logged in';
            return;
        }

        if (
            $_POST['name'] == '' ||
            $_POST['username'] == '' ||
            $_POST['email'] == '' ||
            $_POST['password'] == ''
        ) {
            echo 'Incomplete data';
            return;
        }

        $_POST['password'] = password_hash($_POST['password'], PASSWORD_BCRYPT);

        try {
            $isSuccess = $this->userModel->createUser($_POST);

            if (isset($isSuccess) && $isSuccess > 0) {
                //TODO: What to do after register succeed
                // $_SESSION["login"] = true;
            } else {
                echo 'Register failed';
            }
        } catch (PDOException $pdo) {
            $msg = $pdo->getMessage();

            if (str_contains($msg, 'Integrity constraint violation')) {
                echo 'Email or username have been used.';
            } else {
                echo $msg;
            }
        }
    }

    public function logout()
    {
        //echo $_SESSION["access_token"];

        session_unset();
        session_destroy();

        unset($_COOKIE['access_token']);
        setcookie('access_token', null, -1, '/');

        header('Location: /');
        // echo $_SESSION["access_token"];
    }

}
