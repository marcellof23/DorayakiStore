<?php

include "../config/db.php";
include "../models/dorayaki.php";
echo "testing";

$testing = new Database();

$tes = new DorayakiModel($testing);

echo "RES";
echo var_dump($tes->getAllDoriyakis());

?>