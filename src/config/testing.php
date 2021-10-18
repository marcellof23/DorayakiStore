<?php

include "../config/db.php";
include "../config/constant.php";
include "../models/dorayaki.php";
include "../models/user.php";
include "../models/order.php";
include "../controllers/order.php";

session_start();

$testing = new Database();

$tes = new DorayakiModel($testing);

// $data["name"] = "asem8";
// $data["description"] = "nothing";
// $data["price"] = 30000;
// $data["stock"] = 120;
// $data["thumbnail"] = "nothing";

// $tes->createDorayaki($data);

echo ROOT;

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
