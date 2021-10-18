<?php

require_once ROOT . '/config/db.php';
require_once ROOT . '/models/order.php';
require_once ROOT . '/models/user.php';

class OrderController{
    private $db;
    private $orderModel;

    public function __construct()
    {
        $this->db = new Database();
        $this->orderModel = new OrderModel($this->db);
    }

    public function getAdminOrders(){
        $page = $_GET && isset($_GET["page"]) ? $_GET["page"] : 1;
        
        // if (!isset($_SESSION["login"]) && !isset($_SESSION["user_id"])) {
        //     echo 'Authentication required.';
        //     return;
        // }

        $orderData = $this->orderModel->getOrders($page, 0);

        if (!$orderData) {
            echo 'Order data not found';
            return;
        }

        echo 'Admin order with page : ' . $_GET["page"] . ' is found';
    }
    
    public function getUserOrders(){
        $page = $_GET && isset($_GET["page"]) ? $_GET["page"] : 1;
        
        if (!isset($_SESSION["login"]) && !isset($_SESSION["user_id"])) {
            echo 'Authentication required.';
            return;
        }

        $orderData = $this->orderModel->getOrders($page, 1);

        if (!$orderData) {
            echo 'Order data not found';
            return;
        }

        echo 'User order with page : ' . $_GET["page"] . ' is found';
    }

    public function createOrder(){
        if (!$_POST) {
            return;
        }

        if (!isset($_SESSION["login"]) && !isset($_SESSION["user_id"])) {
            echo 'Authentication required.';
            return;
        }

        if (
            $_POST["user_id"] == '' ||
            $_POST['dorayaki_id'] == '' ||
            $_POST['price'] == '' ||
            $_POST['isOrder'] == '' ||
            $_POST['type'] == ''
        ) {
            echo 'Incomplete data';
            return;
        }

        try {
            $data["user_id"] = $_POST["user_id"];
            $data["dorayaki_id"] = $_POST["dorayaki_id"];
            $data["amount"] = $_POST["amount"];
            $data["isOrder"] = $_POST["isOrder"];
            $data["type"] = $_POST["type"];

            $orderData = $this->orderModel->createOrder($data);

            if (!$orderData) {
                echo 'Order is not created!';
                return;
            }
            echo 'Order or dorayaki change successfully created';

        } catch (PDOException $pdo) {
            $msg = $pdo->getMessage();

            if (str_contains($msg, 'Integrity constraint violation')) {
                echo 'name have been used.';
            } else {
                echo $msg;
            }
        }
    }

    public function deleteOrder(){
        if (!$_POST) {
            return;
        }

        if (!isset($_SESSION["login"]) && !isset($_SESSION["user_id"])) {
            echo 'Authentication required.';
            return;
        }

        $idFound = $this->orderModel->getOrderById($_POST["order_id"]);

        if (
            !$idFound
        ) {
            echo 'order_id is not found';
            return;
        }

        $doryakiData = $this->orderModel->deleteOrder($_POST["order_id"]);
        echo 'Order with id : ' . $_POST["order_id"] . ' is successfully deleted';
    }
}

?>