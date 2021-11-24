<?php

include "../models/user.php";
include "../models/dorayaki.php";
include "../models/order.php";

$db = new SQLite3('db/dorayaki.db');

// UserModel::createUserDatabase($db);
// DorayakiModel::createDorayakiDatabase($db);
// OrderModel::createOrderDatabase($db);
// DorayakiModel::createDorayakiOrderTrigger($db);
