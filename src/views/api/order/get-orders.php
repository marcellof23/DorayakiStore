<?php

require_once '../../../config/constant.php';
require_once ROOT . '/controllers/Order.php';

$controller = new OrderController();

if($_GET["type"]=="order"){
    $controller->getUserOrders();
}else{
    $controller->getAdminOrders();
}

?>