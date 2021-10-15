<?php

  include('../../config/db.php');
  include('../../models/user.php');
  include('../../controllers/user.php');

  $dbPath = '../../config/db/dorayaki.db';

  $controller = new UserController($dbPath);

  $controller->register();
  
?>
