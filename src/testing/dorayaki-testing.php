<?php

include "../config/db.php";
include "../config/constant.php";
include "../models/dorayaki.php";
include "../models/user.php";
include "../models/order.php";
include "../controllers/order.php";

session_start();

// Dorayaki Testing

$testing = new Database();

$tes = new DorayakiModel($testing);

$data["name"] = "asem8";
$data["description"] = "nothing";
$data["price"] = 30000;
$data["stock"] = 120;
$data["thumbnail"] = "nothing";

$tes->createDorayaki($data);
