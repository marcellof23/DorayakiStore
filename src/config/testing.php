<?php

include "../config/db.php";
include "../config/constant.php";
include "../models/dorayaki.php";

$testing = new Database();

$tes = new DorayakiModel($testing);

$data["name"] = "Tess4";
$data["description"] = "nothing";
$data["price"] = 30000;
$data["stock"] = 120;
$data["thumbnail"] = "nothing";

$tes->createDorayaki($data);

echo var_dump($tes->getDorayakis(2));
//echo var_dump($tes->getAllDoriyakis());
