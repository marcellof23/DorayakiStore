<?php

include "../config/db.php";
include "../config/constant.php";
include "../models/dorayaki.php";

$testing = new Database();

$tes = new DorayakiModel($testing);

$data["name"] = "Cello";
$data["description"] = "nothing";
$data["price"] = 30000;
$data["stock"] = 120;
$data["thumbnail"] = "nothing";

echo var_dump($tes->getDoriyakis(2));
//echo var_dump($tes->getAllDoriyakis());
