<?php
if (isset($_GET["id"])) {
	$id = $_GET["id"];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<script src="../scripts/__init.js"></script>
	<script src="../scripts/utils/api_util.js"></script>
	<script src="../scripts/utils/formatting.js"></script>
	<script src="../scripts/lib/axois.js"></script>
	<script src="../scripts/generator/template.js"></script>
	<script src="../scripts/generator/card.js"></script>
	<script src="../scripts/generator/control.js"></script>
	<script src="../scripts/generator/admin-pages.js"></script>

	<link rel="stylesheet" href="../styles/index.css">
	<link rel="stylesheet" href="../styles/base.css">
	<link rel="stylesheet" href="../styles/pages.css">
	<link rel="stylesheet" href="../styles/control.css">
	<link rel="stylesheet" href="../styles/card.css">
	<title>Dorayaki</title>
	<link rel="shortcut icon" type="image/png" href="../public/dorayaki.png"/>
</head>
<body>
	<div id="dorayaki-edit-page"></div>
</body>
<script>
	DorayakiEditPage();

	<?php
	if (isset($_GET["id"])) {
	?>

	async function fetchingData() {
		const axois = new AXOIS("/");
		const response = await axois.get('api/dorayaki/get-details?dorayaki_id=<?php echo $id; ?>');

		try {
			const data = JSON.parse(response)
			document.querySelector('.dorayaki-details-text.name input').value = data.name;
			document.querySelector('.dorayaki-details-text.price input').value = data.price;
			document.querySelector('.dorayaki-details-text.stock input').value = data.stock;
			document.querySelector('.dorayaki-details-text.description textarea').value = data.description;
			document.querySelector('#dorayaki-photo').src = data.thumbnail;
		} catch (err) {
			console.log(err)
			document.querySelector('.dorayaki-details').innerHTML = `<div class="alert error" style="grid-column: span 2">${response}</div>`;	
		}
	}

	fetchingData();

	async function editData() {
		const axois = new AXOIS("/");
		const param = {
			dorayaki_id: <?php echo $id; ?>,
			name: document.querySelector('.dorayaki-details-text.name input').value,
			description: document.querySelector('.dorayaki-details-text.description textarea').value,
			price: Number(document.querySelector('.dorayaki-details-text.price input').value),
			stock: Number(document.querySelector('.dorayaki-details-text.stock input').value),
			thumbnail: document.querySelector('#dorayaki-photo').src
		}
		console.log(param)
		const response = await axois.post('api/dorayaki/update', param);

		if (response === 'Dorayaki is successfully updated') {
			window.location = '/admin/dorayaki-details?id=<?php echo $id; ?>'
		} else {
			const alert = document.createElement('div');
			alert.classList.add("alert");
			alert.classList.add("error");
			alert.style.gridColumn = 'span 2';
			alert.textContent = response;

			if (document.querySelector('.alert.error')) {
				document.querySelector('.alert.error').textContent = response;
			} else {
				document.querySelector('.dorayaki-details')
					.insertBefore(alert, document.querySelector('#dorayaki-photo'))
			}
		}
	}

	document.querySelector('.dorayaki-details-main').addEventListener('submit', e => e.preventDefault())
	document.querySelector('.dorayaki-button.primary').addEventListener('click', editData)
  document.querySelector('.dorayaki-button.outline').addEventListener('click', () => {
		history.go(-1)
	});

	<?php
	} else {
	?>
	document.querySelector('.dorayaki-details').innerHTML = `<div class="alert error" style="grid-column: span 2">Current dorayaki is not found</div>`;	
	<?php
	}
	?>
</script>
</html>
