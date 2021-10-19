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
	<div id="dorayaki-add-page"></div>
</body>
<script>
	DorayakiAddPage();

	async function createDorayaki() {
		const axois = new AXOIS("/");
		const param = {
			name: document.querySelector('.dorayaki-details-text.name input').value,
			description: document.querySelector('.dorayaki-details-text.description textarea').value,
			price: Number(document.querySelector('.dorayaki-details-text.price input').value),
			stock: Number(document.querySelector('.dorayaki-details-text.stock input').value),
			thumbnail: document.querySelector('#dorayaki-photo').src || 'https://placeimg.com/640/480/any'
		}
		console.log(param)
		const response = await axois.post('api/dorayaki/create', param);

		if (response === 'Dorayaki is successfully created') {
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

	document.querySelector('.dorayaki-details-main').addEventListener('submit', e => e.preventDefault())
	document.querySelector('.dorayaki-button.primary').addEventListener('click', createDorayaki)
  document.querySelector('.dorayaki-button.outline').addEventListener('click', () => {
		history.go(-1)
	});
</script>
</html>
