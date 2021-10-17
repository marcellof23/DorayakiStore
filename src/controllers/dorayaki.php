<?php

require_once ROOT . '/config/db.php';
require_once ROOT . '/models/dorayaki.php';

class DorayakiController
{
    private $db;
    private $dorayakiModel;

    public function __construct()
    {
        $this->db = new Database();
        $this->dorayakiModel = new DorayakiModel($this->db);
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

        $doryakiData = $this->dorayakiModel->getDorayakiById($_GET["dorayaki_id"]);

        if (!$dorayakiData) {
            echo 'Current dorayaki is not found';
            return;
        }
        
        echo 'Dorayaki with id : ' . $_GET["dorayaki_id"] . ' is found';
    }

    public function getDorayakis()
    {
        $page = $_GET && isset($_GET["page"]) ? $_GET["page"] : 1;

        if (!isset($_SESSION["login"]) && !isset($_SESSION["user_id"])) {
            echo 'Authentication required.';
            return;
        }

        $doryakiData = $this->dorayakiModel->getDorayakis($page);

        if (!$dorayakiData) {
            echo 'Current dorayaki page is not found';
            return;
        }

        echo 'Dorayaki with page : ' . $_GET["page"] . ' is found';
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

        try {
            $data["name"] = $_POST["name"];
            $data["description"] = $_POST["description"];
            $data["price"] = $_POST["price"];
            $data["stock"] = $_POST["stock"];
            $data["thumbnail"] = $_POST["thumbnail"];

            $doryakiData = $this->dorayakiModel->createDoriyaki($data);

            if (!$dorayakiData) {
                echo 'Current dorayaki page is not found';
                return;
            }
            echo 'Dorayaki with data is successfully created';

        } catch (PDOException $pdo) {
            $msg = $pdo->getMessage();

            if (str_contains($msg, 'Integrity constraint violation')) {
                echo 'name have been used.';
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

        try {
            $data["dorayaki_id"] = $_POST["dorayaki_id"];
            $data["name"] = $_POST["name"];
            $data["description"] = $_POST["description"];
            $data["price"] = $_POST["price"];
            $data["stock"] = $_POST["stock"];
            $data["thumbnail"] = $_POST["thumbnail"];

            $doryakiData = $this->dorayakiModel->updateDorayaki($data);

            if (!$dorayakiData) {
                echo 'Current dorayaki page is not found';
                return;
            }
            echo 'Dorayaki with data is successfully updated';

        } catch (PDOException $pdo) {
            $msg = $pdo->getMessage();
            if (str_contains($msg, 'Integrity constraint violation')) {
                echo 'name have been used.';
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

        $idFound = $this->dorayakiModel->getDorayakiById($_POST["dorayaki_id"]);

        if (
            !$idFound
        ) {
            echo 'dorayaki_id is not found';
            return;
        }

        $doryakiData = $this->dorayakiModel->deleteDorayaki($_POST["dorayaki_id"]);
        echo 'Dorayaki with id : ' . $_POST["dorayaki_id"] . ' is successfully deleted';
    }

}
