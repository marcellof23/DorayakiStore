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
            // echo 'Already logged in';
            header("Location: ../index");
            return;
        }

        if ($_POST["username"] == '' || $_POST["password"] == '') {
            // echo 'Incomplete data';
            header("Location: ../login?status=error&msg=Incomplete data");
            return;
        }

        $user = $this->userModel->getUserByUsername($_POST["username"]);

        if ($user) {
            if (password_verify($_POST["password"], $user["password"])) {
                $token = $this->generateToken();

                $_SESSION["login"] = true;
                $_SESSION["user_id"] = $user["user_id"];
                $_SESSION["access_token"] = $token;

                setcookie("username", $_POST["username"], time() + 3600, '/');
                setcookie("access_token", $token, time() + 3600, '/');

                header("Location: ../home");
            } else {
                // echo 'Wrong password';
                header("Location: ../login?status=error&msg=Wrong password");
            }
        } else {
            // echo 'User not found';
            header("Location: ../login?status=error&msg=User not found");
        }
    }

    public function register()
    {
        if (!$_POST) {
            return;
        }

        if (isset($_SESSION["login"])) {
            // echo 'Already logged in';
            header("Location: ../index");
            return;
        }

        if (
            $_POST['name'] == '' ||
            $_POST['username'] == '' ||
            $_POST['email'] == '' ||
            $_POST['password'] == ''
        ) {
            // echo 'Incomplete data';
            header("Location: ../register?status=error&msg=Incomplete data");
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

                header("Location: ../home");
            } else {
                // echo 'Register failed';
                header("Location: ../register?status=error&msg=Register failed");
            }
        } catch (PDOException $pdo) {
            $msg = $pdo->getMessage();

            if (str_contains($msg, 'Integrity constraint violation')) {
                // echo 'Email or username have been used';
                header("Location: ../register?status=error&msg=Email or username have been used");
            } else {
                echo $msg;
            }
        }
    }

    public function logout()
    {
        session_unset();
        session_destroy();

        unset($_COOKIE["access_token"]);
        setcookie("access_token", null, -1, '/');

        header('Location: /');
    }

    public function checkUsername()
    {
        if (!isset($_GET["username"]) || $_GET["username"] == "") {
            echo '0';
            return;
        }

        $user = $this->userModel->getUserByUsername($_GET["username"]);

        if (!$user) {
            echo '0';
            return;
        }

        echo ($user ? '1' : '0');
    }

    public function checkEmail()
    {
        if (!isset($_GET["email"]) || $_GET["email"] == "") {
            echo '0';
            return;
        }

        $user = $this->userModel->getUserByUsername($_GET["email"]);

        if (!$user) {
            echo '0';
            return;
        }

        echo ($user ? '1' : '0');
    }

    public function getUser()
    {
        if (!$_GET) {
            http_response_code(400);
            echo 'Please provide user id';
            return;
        }

        if (!isset($_SESSION["login"]) && !isset($_SESSION["user_id"])) {
            http_response_code(401);
            echo 'Authentication required.';
            return;
        }

        if (
            $_GET["user_id"] == ''
        ) {
            http_response_code(400);
            echo 'Incomplete data';
            return;
        }

        $user = $this->userModel->getUserById($_GET["user_id"]);

        if (!$user) {
            http_response_code(404);
            echo 'User not found';
            return;
        }

        var_dump($user);
    }

    public function getCurrentUser()
    {
        if (!isset($_SESSION["login"]) && !isset($_SESSION["user_id"])) {
            http_response_code(401);
            echo 'Authentication required.';
            return;
        }

        $user = $this->userModel->getUserById($_SESSION["user_id"]);

        if (!$user) {
            http_response_code(404);
            echo 'Current user not found';
            return;
        }

        echo json_encode($user);
    }

    public function updateCurrentUser()
    {
        if (!$_POST) {
            return;
        }

        if (!isset($_SESSION["login"]) && !isset($_SESSION["user_id"])) {
            http_response_code(401);
            echo 'Authentication required.';
            return;
        }

        if (
            $_POST['name'] == '' ||
            $_POST['username'] == '' ||
            $_POST['email'] == ''
        ) {
            http_response_code(400);
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
                http_response_code(404);
                echo 'User not found';
                return;
            }
            echo 'Updated';
        } catch (PDOException $pdo) {
            $msg = $pdo->getMessage();

            if (str_contains($msg, 'Integrity constraint violation')) {
                http_response_code(400);
                echo 'Email or username have been used.';
            } else {
                echo $msg;
            }
        }
    }

    public function updateUser()
    {
        if (!$_POST) {
            return;
        }

        if (!isset($_SESSION["login"]) && !isset($_SESSION["user_id"])) {
            http_response_code(401);
            echo 'Authentication required.';
            return;
        }

        if (
            $_POST["user_id"] == '' ||
            $_POST['name'] == '' ||
            $_POST['username'] == '' ||
            $_POST['email'] == ''
        ) {
            http_response_code(400);
            echo 'Incomplete data';
            return;
        }

        $user = $this->userModel->getUserById($_SESSION["user_id"]);

        if (!$user) {
            http_response_code(404);
            echo 'Current user not found';
            return;
        } else if ($user && !$user["is_admin"]) {
            http_response_code(403);
            echo 'You are not admin';
            return;
        }

        try {
            $isSuccess = $this->userModel->updateUser($_POST);

            if (!$isSuccess) {
                http_response_code(404);
                echo 'User not found';
                return;
            }
            echo 'Updated';
        } catch (PDOException $pdo) {
            $msg = $pdo->getMessage();

            if (str_contains($msg, 'Integrity constraint violation')) {
                http_response_code(400);
                echo 'Email or username have been used.';
            } else {
                echo $msg;
            }
        }
    }

    public function promoteAdmin()
    {
        if (!$_POST) {
            return;
        }

        if (!isset($_SESSION["login"]) && !isset($_SESSION["user_id"])) {
            http_response_code(401);
            echo 'Authentication required.';
            return;
        }

        if (
            $_POST['is_admin'] == '' ||
            $_POST['user_id'] == ''
        ) {
            http_response_code(400);
            echo 'Incomplete data';
            return;
        }

        $user = $this->userModel->getUserById($_SESSION["user_id"]);

        if (!$user) {
            http_response_code(404);
            echo 'Current user not found';
            return;
        } else if ($user && !$user["is_admin"]) {
            http_response_code(403);
            echo 'You are not admin';
            return;
        }

        $isSuccess = $this->userModel->updateAdmin($_POST);

        if (!$isSuccess) {
            http_response_code(404);
            echo 'Target user not found';
            return;
        }
        echo 'Updated';
    }

}
