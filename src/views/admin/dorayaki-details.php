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
	<div id="dorayaki-details-page" class="app"></div>
</body>
<script>
	DorayakiDetailsPage();

	<?php
	if (isset($_GET["id"])) {
	?>

	async function fetchingData() {
		const axois = new AXOIS("/");
		const response = await axois.get('api/dorayaki/get-details?dorayaki_id=<?php echo $id; ?>');

		try {
			const data = JSON.parse(response)
			document.querySelector('.dorayaki-details-text.name span').textContent = data.name;
			document.querySelector('.dorayaki-details-text.price span').textContent = formatCurrency(data.price);
			document.querySelector('.dorayaki-details-text.stock span').textContent = data.stock;
			document.querySelector('.dorayaki-details-text.description p').textContent = data.description;
			document.querySelector('#dorayaki-photo').src = data.thumbnail;
		} catch (err) {
			console.log(err)
			document.querySelector('.dorayaki-details').innerHTML = `<div class="alert error" style="grid-column: span 2">${response}</div>`;	
		}
	}

	fetchingData();

	async function deleteDorayaki() {
		const axois = new AXOIS("/");
		const response = await axois.post('api/dorayaki/delete', {
			dorayaki_id: <?php echo $id; ?>
		});

		if (response === 'Deleted successfully') {
			window.location = '/admin/dorayaki'
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

	document.querySelector('.dorayaki-button.primary').addEventListener('click', () => {
    window.location = '/admin/dorayaki-edit?id=<?php echo $id; ?>'
  })
  document.querySelector('.dorayaki-button.outline').addEventListener('click', deleteDorayaki);

	<?php
	} else {
	?>
	document.querySelector('.dorayaki-details').innerHTML = `<div class="alert error" style="grid-column: span 2">Current dorayaki is not found</div>`;	
	<?php
	}
	?>
</script>
</html>
