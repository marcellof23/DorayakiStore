<?php 
$messages = array("Incomplete data", "Wrong password", "User not found");
session_start();
if (isset($_SESSION["login"]) && isset($_SESSION["user_id"])) {
	header("Location: ./home");
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
	<script src="scripts/lib/axois.js"></script>
	<script src="scripts/api/user.js"></script>
	<script src="scripts/generator/template.js"></script>
	<script src="scripts/generator/control.js"></script>
	<link rel="stylesheet" href="./styles/index.css">
	<link rel="stylesheet" href="./styles/base.css">
	<link rel="stylesheet" href="./styles/control.css">
	<link rel="stylesheet" href="./styles/pages.css">
	<title>Dorayaki</title>
	<link rel="shortcut icon" type="image/png" href="../public/dorayaki.png"/>
</head>
<body>
<div id="form">
		<div class="form-container">
			<div class="form-title">
				Welcome!
			</div>
			<div class="form-subtitle">
				Create an account to continue
			</div>
			<form class="form-container-inner" action="api/register" method="post">
				<?php
				if (isset($_GET["status"]) && isset($_GET["msg"]) && in_array($_GET["msg"], $messages)) {
				?>
				<div class="alert <?php echo $_GET["status"] ?>" style="margin-bottom: 25px">
					<?php echo $_GET["msg"] ?>
				</div>
				<?php
				}
				?>

				<div class="form-login">
					Name
				</div>
				<input class="form-login input"  name="name" placeholder="name" required></input>
				<div class="form-login">
					Username
				</div>
				<input class="form-login input username"  name="username" placeholder="username" required></input>
				<div class="form-login">
					Email
				</div>
				<input class="form-login input email" name="email" type="email" placeholder="email" required></input>
				<div class="form-login">
					Password
				</div>
				<input class="form-login input" name="password" type="password" placeholder="password" required></input>
				<input class="submit" type="submit" name="Register" value="Register"></input>
				<div class="form-bottom-container">
					<div class="terms-policy">Terms & Privacy Policy</div>
					<a class="form-bottom-text" href="/login">LOGIN</a>
				</div>
			</form>
		</div>
	</div>
</body>
<script>

const handleUsernameChange = debounce(async () => {
	const username = document.querySelector('.form-login.input.username').value;
	const res = Number(await checkUsername(username))
	if (res === 1) {
		ShowAlert('info', 'This username has been used', '" style="margin-bottom: 16px', 'afterBegin', 'form-container-inner');
		document.querySelector('.input').disabled = true;
	} else {
		document.querySelector('.input').disabled = false;
	}
})

const handleEmailChange = debounce(async () => {
	const email = document.querySelector('.form-login.input.email').value;
	const res = Number(await checkEmail(email))
	if (res === 1) {
		ShowAlert('info', 'This email has been used', '" style="margin-bottom: 16px', 'afterBegin', 'form-container-inner');
		document.querySelector('.input').disabled = true;
	} else {
		document.querySelector('.input').disabled = false;
	}
})

document.querySelector('.form-login.input.username').addEventListener('input', handleUsernameChange);
document.querySelector('.form-login.input.email').addEventListener('input', handleEmailChange);

</script>
</html>
