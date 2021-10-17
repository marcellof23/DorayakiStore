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
	<div id="form">
		<div class="form-container">
			<div class="form-title">
				Hello!
			</div>
			<div class="form-subtitle">
				Glad to see you again
			</div>
			<form class="form-container-inner" action="api/login" method="post">
				<div class="form-login">
					Email
				</div>
				<input class="form-login input" name="username" placeholder="email"></input>
				<div class="form-login">
					Password
				</div>
				<input class="form-login input" name="password" type="password" placeholder="password"></input>
				<input class="submit" type="submit" name="Login" value="Login"></input>
				<div class="form-bottom-container">
					<div class="terms-policy">Terms & Privacy Policy</div>
					<div class="form-bottom-text">SIGN UP</div>
				</div>
			</form>
		</div>
	</div>
</body>
<script>

</script>
</html>
