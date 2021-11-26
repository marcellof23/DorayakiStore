<?php

require_once '../../../config/constant.php';
require_once ROOT . '/controllers/dorayaki.php';

$controller = new DorayakiController();

$controller->updateStock();
