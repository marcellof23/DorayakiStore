<?php

include "../config/db.php";
include "../config/constant.php";
include "../models/dorayaki.php";
include "../models/user.php";
include "../models/order.php";
include "../controllers/order.php";

session_start();

$testing = new Database();

<<<<<<< HEAD:src/config/testing.php
$tes = new DorayakiModel($testing);

$data["description"] = "nothing";
$data["price"] = 30000;
$data["stock"] = 120;
$data["thumbnail"] = "nothing";

$data["name"] = "asem1";
$tes->createDorayaki($data);

$data["name"] = "asem2";
$tes->createDorayaki($data);

$data["name"] = "asem3";
$tes->createDorayaki($data);

$data["name"] = "asem4";
$tes->createDorayaki($data);

$data["name"] = "asem5";
$tes->createDorayaki($data);
=======
echo ROOT;
>>>>>>> 2d56d5203d9b4ae5109164f5402342af9fc8c73c:src/testing/user-testing.php

$data["name"] = "asem6";
$tes->createDorayaki($data);

$data["name"] = "asem7";
$tes->createDorayaki($data);

$data["name"] = "asem8";
$tes->createDorayaki($data);

$data["name"] = "asem9";
$tes->createDorayaki($data);

$data["name"] = "asem10";
$tes->createDorayaki($data);

$data["name"] = "asem11";
$tes->createDorayaki($data);

$data["name"] = "asem12";
$tes->createDorayaki($data);
// echo var_dump($tes->getDoriyakis(1));
//echo var_dump($tes->getAllDoriyakis());

// $UM = new UserModel($testing);
// echo json_encode($UM -> getUserById(1));
// echo "<br/>";

// $OM = new OrderModel($testing);
// echo json_encode($OM -> getOrders(1,1));
// echo "<br/>";

// $OC = new OrderController();
// // $OC->createOrder();
// $OC->getAdminOrders(1);
// echo "<br/>";
// $OC->getUserOrders(1);
// echo "<br/>";
