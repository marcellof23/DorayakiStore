const HomePage = async () => {
  await userRoute();

  const target = document.getElementById("home");

  let dorayakis = [];
  try {
    const res = await getPopularDorayaki();
    const data = JSON.parse(res);
    const dorayaki_array = data.map((row) =>
      DorayakiCard(row.thumbnail, row.price, row.name, row.dorayaki_id)
    );
    dorayakis = dorayaki_array;
  } catch (err) {
    console.log(err);
  }

  console.log(dorayakis.length);

  const searchBar = new SearchBar("search-box", "/search");

  const components = `
		${generateNavbar()}
		${searchBar.render()}
		<div class="home-container">
			<div class="not-found-container">
			</div>
      ${dorayakis.join("")}
		</div>
	`;

  target.innerHTML = components;

  if (dorayakis.length == 0) {
    console.log("WOI");
    const targets = document.querySelector(".not-found-container");
    targets.innerHTML = "Dorayaki not found";
  }
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
  let histories = [];

  try {
    const res = await getOrderPage();
    const data = JSON.parse(res);

    const history_array = data.entries.map((row) =>
      HistoryCard(row.createdAt, row.dorayaki, row.amount)
    );

    histories = history_array;
  } catch (err) {
    console.log(err);
  }

  const components = `
		${generateNavbar()}
		<div class="history-container">
			${pageTitle("Riwayat Pembelian")}
			<div class="not-found-container">
			</div>
			${histories.join("")}
		</div>
	`;

  target.innerHTML = components;

  if (histories.length == 0) {
    const targets = document.querySelector(".not-found-container");
    targets.innerHTML = "Histories is empty";
  }
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
