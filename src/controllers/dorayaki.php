<?php

require_once ROOT . '/config/db.php';
require_once ROOT . '/models/dorayaki.php';
require_once ROOT . '/models/order.php';
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

    public function getRecipe()
    {
        $client = new SoapClient(JAXWS_URL . '/api/dorayakiService?wsdl');

        $log_request_id = 1;
        $response = $client->__soapCall("getDorayakiRecipes", array($log_request_id));
        $result = json_decode(json_encode($response), true);

        $dorayakis = array();
        
        if (!isset($result['dorayakirecipes'])) {
            http_response_code(400);
            echo 'Rate limitted';
            return;
        }

        $result = $result['dorayakirecipes'];
        foreach ($result as $res) {
            $dorayaki = array(
                "recipe_id" => $res['recipe_id'],
                "name" => $res['name'],
            );
            array_push($dorayakis, $dorayaki);
        }

        echo json_encode($dorayakis);
    }

    public function getLogTest()
    {

        $client = new SoapClient(JAXWS_URL . "/api/logService?wsdl");

        $log_request_id = 1;
        $response = $client->__soapCall("getLogs", array($log_request_id));
        $result = json_decode(json_encode($response), true);

        $logreqs = array();
        if (!isset($result['logs'])) {
            http_response_code(400);
            echo 'Rate limitted';
            return;
        }

        $result = $result['logs'];
        foreach ($result as $res) {
            $logreq = array(
                "ip" => $res['ip'],
                "endpoint" => $res['endpoint'],
                "timestamp" => $res['timestamp'],
            );
            array_push($logreqs, $logreq);
        }

        echo json_encode($logreqs);
        // print_r($stdClass['logs'][0]['ip']);
    }

    public function getDorayakiById()
    {
        if (!$_GET || !isset($_GET["dorayaki_id"])) {
            http_response_code(400);
            echo 'Please provide dorayaki id';
            return;
        }

        if (!isset($_SESSION["login"]) && !isset($_SESSION["user_id"])) {
            http_response_code(401);
            echo 'Authentication required.';
            return;
        }

        if (
            $_GET["dorayaki_id"] == ''
        ) {
            http_response_code(400);
            echo 'Incomplete data';
            return;
        }

        $dorayakiData = $this->dorayakiModel->getDorayakiById($_GET["dorayaki_id"]);

        if (!$dorayakiData) {
            http_response_code(404);
            echo 'Current dorayaki is not found';
            return;
        }

        echo json_encode($dorayakiData);
    }

    public function getAllDorayaki()
    {

        $dorayakiData = $this->dorayakiModel->getAllDorayakis();

        if (!$dorayakiData) {
            http_response_code(404);
            echo 'Current dorayaki page is not found';
            return;
        }

        echo json_encode($dorayakiData);
    }

    public function getDorayakis()
    {

        $page = $_GET && isset($_GET["page"]) ? $_GET["page"] : 1;

        if (!isset($_SESSION["login"]) && !isset($_SESSION["user_id"])) {
            http_response_code(401);
            echo 'Authentication required.';
            return;
        }

        $dorayakiData = $this->dorayakiModel->getDorayakis($page);

        if (!$dorayakiData) {
            http_response_code(404);
            echo 'Current dorayaki page is not found';
            return;
        }
        $res = array();
        $res['entries'] = $dorayakiData;
        $res['items_per_page'] = 10;
        $res['item_count'] = $this->dorayakiModel->countDorayakis()[0]["total_dorayaki"];
        $res["page"] = $page;
        $res['page_count'] = floor($this->dorayakiModel->countDorayakis()[0]["total_dorayaki"]
            / $res['items_per_page']) + 1;

        echo json_encode($res);
    }

    public function getDorayakiByQuery()
    {
        if (!isset($_SESSION["login"]) && !isset($_SESSION["user_id"])) {
            http_response_code(401);
            echo 'Authentication required.';
            return;
        }

        $query = $_GET["query"];
        $page = $_GET["page"];
        $dorayakiData = $this->dorayakiModel->getDorayakiByQuery($query, $page);

        $res['entries'] = $dorayakiData;
        $res['items_per_page'] = 10;
        $res['item_count'] = $this->dorayakiModel->countDorayakisQuery($query)[0]["total_dorayaki"];
        $res["page"] = $page;
        $res['page_count'] = floor($res["item_count"]
            / $res['items_per_page']) + 1;

        if (!$dorayakiData) {
            http_response_code(404);
            echo 'Current dorayaki query is not found';
            return;
        }

        echo json_encode($res);
    }

    public function getDorayakiPopularVariant()
    {

        $page = $_GET && isset($_GET["page"]) ? $_GET["page"] : 1;

        if (!isset($_SESSION["login"]) && !isset($_SESSION["user_id"])) {
            http_response_code(401);
            echo 'Authentication required.';
            return;
        }

        $dorayakiData = $this->dorayakiModel->getDorayakiPopularVariant();

        if (!$dorayakiData) {
            http_response_code(404);
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
            http_response_code(401);
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
            $data["name"] = $_POST["name"];
            $data["description"] = $_POST["description"];
            $data["price"] = $_POST["price"];
            $data["stock"] = $_POST["stock"];
            $data["thumbnail"] = $_POST["thumbnail"];

            $isExist = false;

            $client = new SoapClient(JAXWS_URL . '/api/dorayakiService?wsdl');

            $recipe_id = 1;
            $response = $client->__soapCall("getDorayakiRecipes", array($recipe_id));
            $result = json_decode(json_encode($response), true);

            $dorayakis = array();
            $result = $result['dorayakirecipes'];
            foreach ($result as $res) {
                $dorayaki = array(
                    "recipe_id" => $res['recipe_id'],
                    "name" => $res['name'],
                );
                array_push($dorayakis, $dorayaki);
            }

            foreach ($dorayakis as $recipe) {
                if ($recipe["name"] == $data["name"]) {
                    $isExist = true;
                    break;
                }
            }

            if (!$isExist) {
                http_response_code(500);
                echo 'Dorayaki is not exists in factory';
                return;
            }

            $dorayakiData = $this->dorayakiModel->createDorayaki($data);

            if (!$dorayakiData) {
                http_response_code(500);
                echo 'Failed to create dorayaki';
                return;
            }

            $dorayakiData = $this->dorayakiModel->getDorayakiByName($_POST["name"]);

            // create order for the initial stock
            if ($_POST["stock"] !== 0) {
                $orderModel = new OrderModel($this->db);

                $orderData["user_id"] = $_SESSION["user_id"];
                $orderData["dorayaki_id"] = $dorayakiData["dorayaki_id"];
                $orderData["amount"] = $_POST["stock"];
                $orderData["price"] = $_POST["price"];
                $orderData["isOrder"] = false;
                $orderData["type"] = "ADD";

                $orderModel->createOrder($orderData);
            }

            echo 'Dorayaki is successfully created';
        } catch (PDOException $pdo) {
            $msg = $pdo->getMessage();

            if (str_contains($msg, 'Integrity constraint violation')) {
                http_response_code(400);
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
            http_response_code(401);
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
            $data["dorayaki_id"] = $_POST["dorayaki_id"];
            $data["name"] = $_POST["name"];
            $data["description"] = $_POST["description"];
            $data["price"] = $_POST["price"];
            $data["stock"] = $_POST["stock"];
            $data["thumbnail"] = $_POST["thumbnail"];

            if ($data["stock"] < 0) {
                http_response_code(400);
                echo 'Stock cannot be negative';
                return;
            }

            $oldDorayakiData = $this->dorayakiModel->getDorayakiById($data["dorayaki_id"]);

            if ($data["stock"] < $oldDorayakiData["stock"]) {
                http_response_code(400);
                echo 'You cannot decrease the stock';
                return;
            }

            // create dorayaki request if stock changed
            if ($oldDorayakiData["stock"] !== $_POST["stock"]) {
                $client = new SoapClient(JAXWS_URL . "/api/dorayakiService?wsdl");

                $log_request_id = 1;
                $response = $client->__soapCall("getDorayakiRecipes", array($log_request_id));
                $result = json_decode(json_encode($response), true);

                if (!isset($result['dorayakirecipes'])) {
                    http_response_code(400);
                    echo 'Rate limitted';
                    return;
                }

                $result = $result['dorayakirecipes'];
                foreach ($result as $res) {
                    if ($res["name"] == $data["name"]) {
                        $recipe_id = $res["recipe_id"];
                    }
                }

                if (!isset($recipe_id)) {
                    http_response_code(400);
                    echo 'Recipe not found in factory';
                    return;
                }

                $client = new SoapClient(JAXWS_URL . "/api/dorayakiService?wsdl");
                $dorayaki_id = $data["dorayaki_id"];
                $dorayaki_stock = $data["stock"] - $oldDorayakiData["stock"];
    
                $dorayakireqitem = array(
                    "username" => $user["username"],
                    "dorayakirequest_id" => 1,
                    "recipe_id" => $recipe_id,
                    "qty" => $dorayaki_stock,
                );
    
                $dorayakireq = array(
                    "dorayakirequests" => $dorayakireqitem,
                );
    
                $response = $client->__soapCall("updateDorayaki", $dorayakireq);
    
                $result = json_decode(json_encode($response), true);

                if (!isset($result['code'])) {
                    http_response_code(400);
                    echo 'Rate limitted';
                    return;
                }
    
                if ($result["code"] != 200) {
                    http_response_code(500);
                    echo 'Failed to request a new dorayaki request to factory';
                    return;
                }
            }

            $data["stock"] = $oldDorayakiData["stock"];
            $dorayakiData = $this->dorayakiModel->updateDorayaki($data);

            if (!$dorayakiData) {
                http_response_code(404);
                echo 'Dorayaki is not found';
                return;
            }

            if ($oldDorayakiData["stock"] !== $_POST["stock"]) {
                echo 'Dorayaki request submitted';
                return;
            }

            echo 'Dorayaki is successfully updated';
        } catch (PDOException $pdo) {
            $msg = $pdo->getMessage();
            if (str_contains($msg, 'Integrity constraint violation')) {
                http_response_code(400);
                echo 'Dorayaki name have been used.';
            } else {
                echo $msg;
            }
        }
    }

    public function updateStock()
    {
        if (!$_POST) {
            return;
        }

        if (
            $_POST["name"] == '' ||
            $_POST["stock"] == ''
        ) {
            http_response_code(400);
            echo 'Incomplete data';
            return;
        }
        
        $data = $this->dorayakiModel->getDorayakiByName($_POST["name"]);
        if (!$data) {
            http_response_code(404);
            echo 'Dorayaki not found';
            return;
        }
        $data["stock"] = $data["stock"] + $_POST["stock"];

        $dorayakiData = $this->dorayakiModel->updateDorayaki($data);

        if (!$dorayakiData) {
            http_response_code(404);
            echo 'Dorayaki is not found';
            return;
        }

        echo 'Dorayaki is successfully updated';
    }

    public function deleteDorayaki()
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

        if (isset($_POST["dorayaki_id"]) && $_POST["dorayaki_id"] == '') {
            http_response_code(400);
            echo 'Incomplete data';
            return;
        }

        $idFound = $this->dorayakiModel->getDorayakiById($_POST["dorayaki_id"]);

        if (
            !$idFound
        ) {
            http_response_code(404);
            echo 'Dorayaki not found';
            return;
        }

        $dorayakiData = $this->dorayakiModel->getDorayakiById($_POST["dorayaki_id"]);

        // create order for the initial stock
        if ($dorayakiData["stock"] !== 0) {
            $orderModel = new OrderModel($this->db);

            $orderData["user_id"] = $_SESSION["user_id"];
            $orderData["dorayaki_id"] = $_POST["dorayaki_id"];
            $orderData["amount"] = $dorayakiData["stock"];
            $orderData["price"] = $dorayakiData["price"];
            $orderData["isOrder"] = false;
            $orderData["type"] = "MIN";

            $orderModel->createOrder($orderData);
        }

        $dorayakiData = $this->dorayakiModel->deleteDorayaki($_POST["dorayaki_id"]);

        echo 'Deleted successfully';
    }

    public function uploadDorayakiImage()
    {
        if (!isset($_POST)) {
            return;
        }

        if (!isset($_SESSION["login"]) && !isset($_SESSION["user_id"])) {
            http_response_code(401);
            echo 'Authentication required.';
            return;
        }

        $target_dir = ROOT . "/public/upload/";
        $target_file = $target_dir . basename($_FILES["userfile"]["name"]);

        if (move_uploaded_file($_FILES["userfile"]["tmp_name"], $target_file)) {
            echo "The file " . htmlspecialchars(basename($_FILES["userfile"]["name"])) . " has been uploaded.";
        } else {
            http_response_code(500);
            echo "Sorry, there was an error uploading your file.";
        }
    }

}
