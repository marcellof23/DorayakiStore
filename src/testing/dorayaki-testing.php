<?php

include "../config/db.php";
include "../config/constant.php";
include "../models/dorayaki.php";
include "../models/user.php";
include "../models/order.php";
include "../controllers/order.php";
include "../controllers/dorayaki.php";

session_start();

// Dorayaki Testing

$testing = new Database();

$tes_model = new DorayakiModel($testing);
$tes_controller = new DorayakiController($testing);

$data["name"] = "asem8";
$data["description"] = "nothing";
$data["price"] = 30000;
$data["stock"] = 120;
$data["thumbnail"] = "nothing";

$_GET["page"] = 1;
// $tes_model->createDorayaki($data);
var_dump($tes_controller->getDorayakis());
