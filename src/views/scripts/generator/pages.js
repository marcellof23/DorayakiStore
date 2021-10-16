const HomePage = () => {
	const target = document.getElementById("home");

	const data = [
		{
			thumbnail: "https://picsum.photos/200",
			price: 60,
			name: "Paket spesial 6 dorayaki",
		},
		{
			thumbnail: "https://picsum.photos/200",
			price: 20,
			name: "Dorayaki spesial raspberry",
		},
	];

	const dorayakis = data.map((row) =>
		DorayakiCard(row.thumbnail, row.price, row.name)
	);

	const components = `
		${generateNavbar()}
		<div class="home-container">
			${pageTitle("Yoshiyaki")}
			<h5 class="home-subtitle">Our latest dorayaki</h5>
			${dorayakis.join("")}
		</div>
	`;

	target.innerHTML = components;
};

const SearchPage = () => {
	const target = document.getElementById("search");

	const data = [
		{
			thumbnail: "https://picsum.photos/200",
			price: 60,
			name: "Paket spesial 6 dorayaki",
		},
		{
			thumbnail: "https://picsum.photos/200",
			price: 20,
			name: "Dorayaki spesial raspberry",
		},
	];

	const dorayakis = data.map((row) =>
		DorayakiCard(row.thumbnail, row.price, row.name)
	);

	const components = `
		${generateNavbar()}
		${SearchBar()}
		<div class="search-container">
			${dorayakis.join("")}
		</div>
	`;

	target.innerHTML = components;
};

const HistoryPage = () => {
	const target = document.getElementById("history");

	const data = [
		{
			thumbnail: "https://picsum.photos/200",
			createdAt: new Date(),
			title: "Dorayaki spesial",
			amount: 180,
		},
		{
			thumbnail: "https://picsum.photos/200",
			createdAt: new Date(),
			title: "Dorayaki spesial",
			amount: 180,
		},
	];

	const histories = data.map((row) =>
		HistoryCard(row.thumbnail, row.createdAt, row.title, row.amount)
	);

	const components = `
		${generateNavbar()}
		<div class="history-container">
			${pageTitle("Riwayat Pembelian")}
			${histories.join("")}
		</div>
	`;

	target.innerHTML = components;
};
