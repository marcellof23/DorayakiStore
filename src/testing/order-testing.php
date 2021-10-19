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

$tess = new OrderModel($testing);

$data["user_id"] = "1";
$data["dorayaki_id"] = "3";
$data["amount"] = 3000;
$data["total_cost"] = 120;
$data["price"] = 1000;
$data["isOrder"] = "1";
$data["createdAt"] = "nothing";
$data["type"] = "ADD";

$tess->createOrder($data);
