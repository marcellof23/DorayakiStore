<?php

require_once '../../../config/constant.php';
require_once ROOT . '/controllers/order.php';

$controller = new OrderController();

if($_GET["type"]=="admin"){
  $controller->getAdminOrders();
}else{
  $controller->getUserOrders();
}

?>