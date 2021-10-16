<?php

require_once('../../config/constant.php');
require_once(ROOT . '/controllers/user.php');

$controller = new UserController();

$controller->register();
  
?>
