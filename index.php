<?php
session_unset();
require_once 'controller/user.php';
$controller = new userController();
$controller->mvcHandler();
