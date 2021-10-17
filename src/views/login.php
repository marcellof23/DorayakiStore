<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<script src="scripts/__init.js"></script>
	<script src="scripts/utils/api_util.js"></script>
	<script src="scripts/utils/formatting.js"></script>
	<script src="scripts/lib/axois.js"></script>
	<script src="scripts/generator/template.js"></script>
	<script src="scripts/generator/card.js"></script>
	<script src="scripts/generator/control.js"></script>
	<link rel="stylesheet" href="./styles/index.css">
	<link rel="stylesheet" href="./styles/base.css">
	<link rel="stylesheet" href="./styles/pages.css">
	<title>Dorayaki</title>
	<link rel="shortcut icon" type="image/png" href="../public/dorayaki.png"/>
</head>
<body>
	<div id="login">
		<div class="login-container">
			<form class="form-container" action="api/login" method="post">
				Login
				<input name="username" placeholder="username"></input>
				Password
				<input name="password" type="password" placeholder="password"></input>
				<input type="submit" name="Login"></input>
			</form>
		</div>
	</div>
</body>
<script>

</script>
</html>
