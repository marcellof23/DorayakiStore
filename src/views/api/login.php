<?php

require_once '../../config/constant.php';
require_once ROOT . '/controllers/user.php';

$controller = new UserController();

$controller->login();

$id = session_id();
print("\nSession Id: " . $id);
//print("\nTes " . $user["password"]);
