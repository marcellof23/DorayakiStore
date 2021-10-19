<?php

require_once '../../../config/constant.php';
require_once(ROOT . '/controllers/order.php');

$controller = new OrderController();

$controller->createOrder();
  
?>
