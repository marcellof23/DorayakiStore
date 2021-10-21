const HomePage = async () => {
	await userRoute();

	const target = document.getElementById("home");

	const res = await getPopularDorayaki();
	const data = JSON.parse(res);

	const dorayakis = data.map((row) =>
		DorayakiCard(row.thumbnail, row.price, row.name, row.dorayaki_id)
	);

	const searchBar = new SearchBar("search-box", "/search");

	const components = `
		${generateNavbar()}
		${searchBar.render()}
		<div class="home-container">
      ${dorayakis.join("")}
		</div>
	`;

	target.innerHTML = components;
};

const SearchPage = async () => {
	await userRoute();

	const target = document.getElementById("search");

	const searchBar = new SearchBar("search-box", "/search");

	const url = new URL(window.location.href);
	const q = url.searchParams.get("query");

	const res = await getSearchedDorayaki(q);
	const data = JSON.parse(res);

	const dorayakis = data.map((row) =>
		DorayakiCard(row.thumbnail, row.price, row.name, row.dorayaki_id)
	);

	const components = `
		${generateNavbar()}
		${searchBar.render()}
		<div class="search-container">
      ${dorayakis.join("")}
		</div>
	`;

	target.innerHTML = components;
};

const HistoryPage = async () => {
	await userRoute();

	const target = document.getElementById("history");

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

const BuyPage = async () => {
	await userRoute();

	const target = document.getElementById("buy");

	const url = new URL(window.location.href);
	const id = url.searchParams.get("id");
	const counter_id = "counter";

	const res = await getDorayakiDetail(id);
	const data = JSON.parse(res);

	const counter_cb = (val) => `
    const total = document.getElementById("total");
    total.innerHTML = formatCurrency(${val} * ${data.price});
  `;
	const counter = new Counter(counter_id, counter_cb);

	const onSubmit = `buyDorayaki("${id}","${counter_id}")`;
	const onCancel = `redirect("/home")`;

	const components = `
    ${generateNavbar()}
    <div class="buy-container">
      ${pageTitle("Pemesanan")}
      <img class="dorayaki-image" src="${data.thumbnail}">
      <p class="dorayaki-name">${data.name}</p>
      <h4 class="dorayaki-price">IDR ${formatCurrency(data.price)}</h4>
      <div class="form">
        ${counter.render()}
        <div class="total-cost">
          <p>Total Cost</p>
          <h3 id="total">${formatCurrency(data.price)}</h3>
        </div>
        <div class="button-container">
          ${Button("Gas, Saya Sultan!", true, onSubmit)}
          ${Button("Gajadi gan, masih miskin :(", false, onCancel)}
        </div>
      </div>
    </div>
  `;

	target.innerHTML = components;
};