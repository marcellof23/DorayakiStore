<?php

include "../config/db.php";
include "../config/constant.php";
include "../models/dorayaki.php";
include "../models/user.php";
include "../models/order.php";
include "../controllers/order.php";

session_start();

$testing = new Database();

// Order Testing

$tes_model = new OrderModel($testing);

// for ($x = 0; $x <= 10; $x++) {
//     $data["user_id"] = "1";
//     $data["dorayaki_id"] = "3";
//     $data["amount"] = 1;
//     $data["total_cost"] = 120;
//     $data["price"] = 1000;
//     $data["isOrder"] = "0";
//     $data["createdAt"] = "nothing";
//     $data["type"] = "ADD";

//     $tes_model->createOrder($data);
// }


echo json_encode($tes_model->getOrders(1,0));