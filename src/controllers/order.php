<?php

require_once ROOT . '/config/db.php';
require_once ROOT . '/models/dorayaki.php';
require_once ROOT . '/models/order.php';
require_once ROOT . '/models/user.php';

class OrderController
{
    private $db;
    private $orderModel;
    private $userModel;

    public function __construct()
    {
        $this->db = new Database();
        $this->orderModel = new OrderModel($this->db);
        $this->userModel = new UserModel($this->db);

        session_start();
    }

    public function getAdminOrders()
    {
        $page = $_GET && isset($_GET["page"]) ? $_GET["page"] : 1;

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
        } else if ($user && !$user["is_admin"]) {
            http_response_code(403);
            echo 'You are not admin';
            return;
        }

        $orderData = $this->orderModel->getOrders($page, 0);

        if (!$orderData) {
            http_response_code(404);
            echo 'Order data not found';
            return;
        }

        $res = array();
        $res['entries'] = $orderData;
        $res["items_per_page"] = 10;
        $res["item_count"] = $this->orderModel->countOrders(0)[0]["total_order"];
        $res["page"] = $page;
        $res["page_count"] = floor($res["item_count"] / $res["items_per_page"]) + 1;

        echo json_encode($res);
    }

    public function getUserOrders()
    {
        $page = $_GET && isset($_GET["page"]) ? $_GET["page"] : 1;

        if (!isset($_SESSION["login"]) && !isset($_SESSION["user_id"])) {
            http_response_code(401);
            echo 'Authentication required.';
            return;
        }

        $user_id = $_SESSION["user_id"];
        $user = $this->userModel->getUserById($user_id);

        $orderData = $user["is_admin"] ? $this->orderModel->getOrders($page, 1) : $this->orderModel->getOrderByUserId($page, $user["user_id"]);

        if (!$orderData) {
            http_response_code(404);
            echo 'Order data not found';
            return;
        }

        $res = array();
        $res['entries'] = $orderData;
        $res["items_per_page"] = 10;
        $res["item_count"] = $user["is_admin"] ? $this->orderModel->countOrders(1)[0]["total_order"] : $this->orderModel->countOrderByUserId($user["user_id"])[0]["total_order"];
        $res["page"] = $page;
        $res["page_count"] = floor($res["item_count"] / $res["items_per_page"]) + 1;

        echo json_encode($res);
    }

    public function createOrder()
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
            $_POST['dorayaki_id'] == '' ||
            $_POST['amount'] == ''
        ) {
            http_response_code(400);
            echo 'Incomplete data';
            return;
        }

        $user = $this->userModel->getUserById($_SESSION["user_id"]);

        $data = array();

        if (!$user) {
            http_response_code(404);
            echo 'Current user not found';
            return;
        } else {
            if (!$user["is_admin"]) {
                $data["isOrder"] = 1;
                $data["type"] = "MIN";
            } else {
                http_response_code(500);
                echo 'Order is not created!';
                return;
            }
        }

        try {
            $data["user_id"] = $_SESSION["user_id"];
            $data["dorayaki_id"] = $_POST["dorayaki_id"];
            $data["amount"] = $_POST["amount"];

            $dorayakiModel = new DorayakiModel($this->db);
            $dorayakiData = $dorayakiModel->getDorayakiById($data["dorayaki_id"]);

            if (!$dorayakiData) {
                http_response_code(400);
                echo 'Dorayaki not valid!';
                // echo json_encode($data);
                // echo json_encode($dorayakiData);
                return;
            }

            if ($data["amount"] > $dorayakiData["stock"]) {
                http_response_code(400);
                echo 'Stock not enough';
                return;
            }

            $data["price"] = $dorayakiData["price"];

            $orderData = $this->orderModel->createOrder($data);
            
            $dorayakiData["stock"] = $dorayakiData["stock"] - $data["amount"];
            $rc = $dorayakiModel->updateDorayaki($dorayakiData);

            if (!$rc) {
                http_response_code(500);
                echo 'Failed to update dorayaki stock';
                return;
            }

            if (!$orderData) {
                http_response_code(500);
                echo 'Order is not created!';
                return;
            }
            echo 'Order or dorayaki change successfully created';
        } catch (PDOException $pdo) {
            $msg = $pdo->getMessage();

            if (str_contains($msg, 'Integrity constraint violation')) {
                http_response_code(400);
                echo 'Doriyaki name have been used.';
            } else {
                echo $msg;
            }
        }
    }

    public function deleteOrder()
    {
        if (!$_POST) {
            return;
        }

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
        } else if ($user && !$user["is_admin"]) {
            http_response_code(403);
            echo 'You are not admin';
            return;
        }

        if (isset($_POST["order_id"]) && $_POST["order_id"] == '') {
            http_response_code(400);
            echo 'Incomplete data';
            return;
        }

        $idFound = $this->orderModel->getOrderById($_POST["order_id"]);

        if (
            !$idFound
        ) {
            http_response_code(404);
            echo 'Order not found';
            return;
        }

        $orderData = $this->orderModel->deleteOrder($_POST["order_id"]);
        echo 'Order with id : ' . $_POST["order_id"] . ' is successfully deleted';
    }
}
