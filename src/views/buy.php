<?php 
session_start();
if (!isset($_SESSION["login"]) && !isset($_SESSION["user_id"])) {
	header("Location: ./login");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<script src="scripts/__init.js"></script>
	<script src="scripts/utils/api_util.js"></script>
	<script src="scripts/utils/formatting.js"></script>
  <script src="scripts/api/user.js"></script>
  <script src="scripts/api/dorayaki.js"></script>
	<script src="scripts/lib/axois.js"></script>
	<script src="scripts/lib/modal.js"></script>
	<script src="scripts/generator/template.js"></script>
	<script src="scripts/generator/card.js"></script>
	<script src="scripts/generator/control.js"></script>
	<script src="scripts/generator/pages.js"></script>
	<link rel="stylesheet" href="./styles/index.css">
	<link rel="stylesheet" href="./styles/base.css">
	<link rel="stylesheet" href="./styles/pages.css">
	<link rel="stylesheet" href="./styles/control.css">
	<link rel="stylesheet" href="./styles/card.css">
	<title>Dorayaki</title>
	<link rel="shortcut icon" type="image/png" href="../public/dorayaki.png"/>
</head>
<body>
	<div id="buy" class="app"></div>
	<div id="modal-portal"></div>
</body>
<script>
	BuyPage()
</script>
</html>
