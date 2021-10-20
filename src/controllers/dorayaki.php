<?php

require_once ROOT . '/config/db.php';
require_once ROOT . '/models/dorayaki.php';
require_once ROOT . '/models/user.php';

class DorayakiController
{
    private $db;
    private $dorayakiModel;

    public function __construct()
    {
        $this->db = new Database();
        $this->dorayakiModel = new DorayakiModel($this->db);
        $this->userModel = new UserModel($this->db);

        session_start();
    }

    public function getDorayakiById()
    {
        if (!$_GET) {
            echo 'Please provide dorayaki id';
            return;
        }

        if (!isset($_SESSION["login"]) && !isset($_SESSION["user_id"])) {
            echo 'Authentication required.';
            return;
        }

        if (
            $_GET["dorayaki_id"] == ''
        ) {
            echo 'Incomplete data';
            return;
        }

        $dorayakiData = $this->dorayakiModel->getDorayakiById($_GET["dorayaki_id"]);

        if (!$dorayakiData) {
            echo 'Current dorayaki is not found';
            return;
        }

        echo json_encode($dorayakiData);
    }

    public function getDorayakis()
    {

        $page = $_GET && isset($_GET["page"]) ? $_GET["page"] : 1;

        if (!isset($_SESSION["login"]) && !isset($_SESSION["user_id"])) {
            echo 'Authentication required.';
            return;
        }

        $dorayakiData = $this->dorayakiModel->getDorayakis($page);

        if (!$dorayakiData) {
            echo 'Current dorayaki page is not found';
            return;
        }

        echo json_encode($dorayakiData);
    }

    public function getDorayakiPopularVariant()
    {

        $page = $_GET && isset($_GET["page"]) ? $_GET["page"] : 1;

        if (!isset($_SESSION["login"]) && !isset($_SESSION["user_id"])) {
            echo 'Authentication required.';
            return;
        }

        $dorayakiData = $this->dorayakiModel->getDorayakiPopularVariant();

        if (!$dorayakiData) {
            echo 'Current dorayaki page is not found';
            return;
        }

        echo json_encode($dorayakiData);
    }

    public function createDorayaki()
    {
        if (!$_POST) {
            return;
        }

        if (!isset($_SESSION["login"]) && !isset($_SESSION["user_id"])) {
            echo 'Authentication required.';
            return;
        }

        if (
            $_POST["name"] == '' ||
            $_POST['description'] == '' ||
            $_POST['price'] == '' ||
            $_POST['stock'] == '' ||
            $_POST['thumbnail'] == ''
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
            $data["name"] = $_POST["name"];
            $data["description"] = $_POST["description"];
            $data["price"] = $_POST["price"];
            $data["stock"] = $_POST["stock"];
            $data["thumbnail"] = $_POST["thumbnail"];

            $dorayakiData = $this->dorayakiModel->createDorayaki($data);

            if (!$dorayakiData) {
                echo 'Failed to create dorayaki';
                return;
            }

            echo 'Dorayaki is successfully created';
        } catch (PDOException $pdo) {
            $msg = $pdo->getMessage();

            if (str_contains($msg, 'Integrity constraint violation')) {
                echo 'Dorayaki name have been used.';
            } else {
                echo $msg;
            }
        }
    }

    public function updateDorayaki()
    {
        if (!$_POST) {
            return;
        }

        if (!isset($_SESSION["login"]) && !isset($_SESSION["user_id"])) {
            echo 'Authentication required.';
            return;
        }

        if (
            $_POST["dorayaki_id"] == '' ||
            $_POST["name"] == '' ||
            $_POST['description'] == '' ||
            $_POST['price'] == '' ||
            $_POST['stock'] == '' ||
            $_POST['thumbnail'] == ''
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
            $data["dorayaki_id"] = $_POST["dorayaki_id"];
            $data["name"] = $_POST["name"];
            $data["description"] = $_POST["description"];
            $data["price"] = $_POST["price"];
            $data["stock"] = $_POST["stock"];
            $data["thumbnail"] = $_POST["thumbnail"];

            $dorayakiData = $this->dorayakiModel->updateDorayaki($data);

            if (!$dorayakiData) {
                echo 'Dorayaki is not found';
                return;
            }
            echo 'Dorayaki is successfully updated';

        } catch (PDOException $pdo) {
            $msg = $pdo->getMessage();
            if (str_contains($msg, 'Integrity constraint violation')) {
                echo 'Dorayaki name have been used.';
            } else {
                echo $msg;
            }
        }
    }

    public function deleteDorayaki()
    {
        if (!$_POST) {
            return;
        }

        if (!isset($_SESSION["login"]) && !isset($_SESSION["user_id"])) {
            echo 'Authentication required.';
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

        if (isset($_POST["dorayaki_id"]) && $_POST["dorayaki_id"] == '') {
            echo 'Incomplete data';
            return;
        }

        $idFound = $this->dorayakiModel->getDorayakiById($_POST["dorayaki_id"]);

        if (
            !$idFound
        ) {
            echo 'Dorayaki not found';
            return;
        }

        $doryakiData = $this->dorayakiModel->deleteDorayaki($_POST["dorayaki_id"]);
        echo 'Deleted successfully';
    }

    public function uploadDorayakiImage()
    {
        if (!isset($_POST)) {
          return;
        }

        if (!isset($_SESSION["login"]) && !isset($_SESSION["user_id"])) {
            echo 'Authentication required.';
            return;
        }

        $target_dir = ROOT . "/public/upload/";
        $target_file = $target_dir . basename($_FILES["userfile"]["name"]);

        if (move_uploaded_file($_FILES["userfile"]["tmp_name"], $target_file)) {
            echo "The file " . htmlspecialchars(basename($_FILES["userfile"]["name"])) . " has been uploaded.";
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }

}
