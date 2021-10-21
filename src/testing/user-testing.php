<?php

include "../config/db.php";
include "../config/constant.php";
include "../models/dorayaki.php";
include "../models/user.php";
include "../models/order.php";
include "../controllers/order.php";
include "../controllers/user.php";

// session_start();

$testing = new Database();

$tes = new UserController($testing);

$_POST["name"] = "antss";
$_POST["username"] = "adads";
$_POST["email"] = "pegessasfdf@gmail.com";
$_POST["password"] = "adads";
$_POST["is_admin"] = "true";

$_POST["user_id"] = "3";
$_SESSION["user_id"] = "3";

$tes->promoteAdmin();
