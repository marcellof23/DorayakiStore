const HomePage = async () => {
	const target = document.getElementById("home");

	await userRoute();

	const components = `
		${generateNavbar()}
		${SearchBar()}
		<div class="home-container">
		</div>
	`;

	target.innerHTML = components;
};

const SearchPage = async () => {
	const target = document.getElementById("search");

	await userRoute();

	const components = `
		${generateNavbar()}
		${SearchBar()}
		<div class="search-container">
		</div>
	`;

	target.innerHTML = components;
};

const HistoryPage = async () => {
	const target = document.getElementById("history");

	await userRoute();

	const res = await getOrderPage();
	const data = JSON.parse(res);

	const histories = data.entries.map((row) =>
		HistoryCard(row.createdAt, row.dorayaki, row.amount)
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
