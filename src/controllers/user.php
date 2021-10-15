<?php

require_once(ROOT . '/config/db.php');
require_once(ROOT . '/models/user.php');

class UserController
{
    private $db;
    private $userModel;

    public function __construct()
    {
        $this->db = new Database();
        $this->userModel = new UserModel($this->db);

        session_start();
    }

    public function generateToken($user) {

    }

    public function destructToken($token) {

    }

    public function login() {
        if (isset($_SESSION["login"])) {
            echo 'Already logged in';
            return;
        }

        if ($_POST["username"] == '' && $_POST["password"] == '') {
            echo 'Incomplete data';
            return;
        }

        $user = $this->userModel->getUserByUsername($_POST["username"]);

        if (isset($user)) {
            if (password_verify($_POST["password"], $user["password"])) {
                //TODO: What to do after login succeed
                // $_SESSION["login"] = true;
                // $_SESSION["user_id"] = $user["user_id"];

                // $token = generateToken($user);
                // $_SESSION["key"] = $token;
                // setcookie('key', $token);

                echo 'Login successful';
            } else {
                echo 'Wrong password';
            }
        } else {
            echo 'User not found';
        }
    }

    public function register() {
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

    public function logout() {
        session_unset();
        session_destroy();

        header('Location: /');
    }

    // public function tampil()
    // {

    //     $stmt = $this->db->prepare("SELECT * FROM tb_mhsw");
    //     $stmt->execute();

    //     $data = array();
    //     while ($rows = $stmt->fetch()) {
    //         $data[] = $rows;
    //     }

    //     return $data;

    // }

    // public function input()
    // {

    //     $mhsw_nim = $_POST['mhsw_nim'];
    //     $mhsw_nama = $_POST['mhsw_nama'];
    //     $mhsw_alamat = $_POST['mhsw_alamat'];
    //     $created_at = Carbon::now();

    //     $sql = "INSERT INTO tb_mhsw (mhsw_nim, mhsw_nama, mhsw_alamat, created_at)
	// 			VALUES (:mhsw_nim, :mhsw_nama, :mhsw_alamat,:created_at)";
    //     $stmt = $this->db->prepare($sql);
    //     $stmt->bindParam(":mhsw_nim", $mhsw_nim);
    //     $stmt->bindParam(":mhsw_nama", $mhsw_nama);
    //     $stmt->bindParam(":mhsw_alamat", $mhsw_alamat);
    //     $stmt->bindParam(":created_at", $created_at);
    //     $stmt->execute();

    //     return false;
    // }

    // public function edit($id)
    // {

    //     $stmt = $this->db->prepare("SELECT * FROM tb_mhsw WHERE mhsw_id=:mhsw_id");
    //     $stmt->bindParam(":mhsw_id", $id);
    //     $stmt->execute();

    //     $row = $stmt->fetch();

    //     return $row;

    // }

    // public function update()
    // {
    //     $mhsw_id = $_POST['mhsw_id'];
    //     $mhsw_nim = $_POST['mhsw_nim'];
    //     $mhsw_nama = $_POST['mhsw_nama'];
    //     $mhsw_alamat = $_POST['mhsw_alamat'];
    //     $updated_at = Carbon::now();

    //     $sql = "UPDATE tb_mhsw SET mhsw_nim=:mhsw_nim,
	// 			mhsw_nama=:mhsw_nama,
	// 			mhsw_alamat=:mhsw_alamat,
	// 			updated_at=:updated_at
	// 			WHERE mhsw_id=:mhsw_id";
    //     $stmt = $this->db->prepare($sql);
    //     $stmt->bindParam(":mhsw_nim", $mhsw_nim);
    //     $stmt->bindParam(":mhsw_nama", $mhsw_nama);
    //     $stmt->bindParam(":mhsw_alamat", $mhsw_alamat);
    //     $stmt->bindParam(":updated_at", $updated_at);
    //     $stmt->bindParam(":mhsw_id", $mhsw_id);
    //     $stmt->execute();

    //     return false;
    // }

    // public function detail($id)
    // {

    //     $stmt = $this->db->prepare("SELECT * FROM tb_mhsw WHERE mhsw_id=:mhsw_id");
    //     $stmt->bindParam(":mhsw_id", $id);
    //     $stmt->execute();

    //     $row = $stmt->fetch();

    //     return $row;
    // }

    // public function delete()
    // {

    //     $id = $_POST['mhsw_id'];

    //     $stmt = $this->db->prepare("DELETE FROM tb_mhsw WHERE mhsw_id=:mhsw_id");
    //     $stmt->bindParam(":mhsw_id", $id);
    //     $stmt->execute();

    //     return false;
    // }
}
