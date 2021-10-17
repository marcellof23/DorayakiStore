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

    public function login()
    {
        if (!$_POST) {
            return;
        }

        if (isset($_SESSION["login"])) {
            header("Location: ../index.php");
            echo 'Already logged in';
            return;
        }

        if ($_POST["username"] == '' && $_POST["password"] == '') {
            echo 'Incomplete data';
            return;
        }

        $user = $this->userModel->getUserByUsername($_POST["username"]);

        if ($user) {
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
        if (!$_POST) {
            return;
        }

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

            if ($isSuccess && $isSuccess > 0) {
                $token = $this->generateToken();

                $_SESSION["login"] = true;
                $_SESSION["user_id"] = $this->userModel->getUserId($_POST["username"])["user_id"];
                $_SESSION["access_token"] = $token;

                setcookie("access_token", $token, time() + 3600, '/');

                header("Location: ../index.php");
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
        session_unset();
        session_destroy();

        print("OIIII");
        var_dump($_COOKIE);

        unset($_COOKIE["access_token"]);
        setcookie("access_token", null, -1, '/');

        header('Location: /');
    }

    public function updateCurrentUser()
    {
        if (!$_POST) {
            return;
        }

        if (!isset($_SESSION["login"]) && !isset($_SESSION["user_id"])) {
            echo 'Authentication required.';
            return;
        }

        if (
            $_POST['name'] == '' ||
            $_POST['username'] == '' ||
            $_POST['email'] == ''
        ) {
            echo 'Incomplete data';
            return;
        }

        try {
            if (isset($_POST["password"])) {
                $_POST['password'] = password_hash($_POST['password'], PASSWORD_BCRYPT);
            }

            $_POST["user_id"] = $_SESSION["user_id"];
            $isSuccess = $this->userModel->updateUser($_POST);

            if (!$isSuccess) {
                echo 'User not found';
                return;
            }
            echo 'Updated';
        } catch (PDOException $pdo) {
            $msg = $pdo->getMessage();

            if (str_contains($msg, 'Integrity constraint violation')) {
                echo 'Email or username have been used.';
            } else {
                echo $msg;
            }
        }
    }

    //TODO: Testing
    public function updateUser()
    {
        if (!$_POST) {
            return;
        }

        if (!isset($_SESSION["login"]) && !isset($_SESSION["user_id"])) {
            echo 'Authentication required.';
            return;
        }

        if (
            $_POST["user_id"] == '' ||
            $_POST['name'] == '' ||
            $_POST['username'] == '' ||
            $_POST['email'] == ''
        ) {
            echo 'Incomplete data';
            return;
        }

        $user = $this->userModel->getUserById($_SESSION["user_id"]);

        if (!$user) {
            echo 'Current user not found';
            return;
        } else if ($user && !$user["is_admin"]) {
            echo 'You are not admin';
            return;
        }

        try {
            $isSuccess = $this->userModel->updateUser($_POST);

            if (!$isSuccess) {
                echo 'User not found';
                return;
            }
            echo 'Updated';
        } catch (PDOException $pdo) {
            $msg = $pdo->getMessage();

            if (str_contains($msg, 'Integrity constraint violation')) {
                echo 'Email or username have been used.';
            } else {
                echo $msg;
            }
        }
    }

    //TODO: Testing
    public function promoteAdmin()
    {
        if (!$_POST) {
            return;
        }

        if (!isset($_SESSION["login"]) && !isset($_SESSION["user_id"])) {
            echo 'Authentication required.';
            return;
        }

        if (
            $_POST['is_admin'] == '' ||
            $_POST['user_id'] == ''
        ) {
            echo 'Incomplete data';
            return;
        }

        $user = $this->userModel->getUserById($_SESSION["user_id"]);

        if (!$user) {
            echo 'Current user not found';
            return;
        } else if ($user && !$user["is_admin"]) {
            echo 'You are not admin';
            return;
        }

        $isSuccess = $this->userModel->updateAdmin($_POST);

        if (!$isSuccess) {
            echo 'Target user not found';
            return;
        }
        echo 'Updated';
    }

}
