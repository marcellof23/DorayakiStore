const HomePage = async () => {
  const user = await userRoute();

  const target = document.getElementById("home");

  let dorayakis = [];
  try {
    const res = await getPopularDorayaki();
    const data = JSON.parse(res);
    data.map((row) =>
      dorayakis.push(
        DorayakiCard(row.thumbnail, row.price, row.name, row.dorayaki_id)
      )
    );
  } catch (err) {
    console.log(err);
  }

  const searchBar = new SearchBar("search-box", "/search");

  const components = `
		${generateNavbar()}
    ${generateUserChip(user)}
		${searchBar.render()}
		<div class="home-container">
      ${
        dorayakis.length
          ? dorayakis.join("")
          : "<div class='not-found-container'>Dorayaki is not found</div>"
      }
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
  const page = parseInt(url.searchParams.get("page")) || 1;

  try {
    const res = await getSearchedDorayaki();
    const data = JSON.parse(res);
    const pagination = new Pagination(
      "pagination",
      page,
      data.page_count,
      `&query=${q}`
    );
    const dorayakis = data.entries.map((row) =>
      DorayakiCard(row.thumbnail, row.price, row.name, row.dorayaki_id)
    );
    const components = `
		${generateNavbar()}
		${searchBar.render()}
		<div class="search-container">
      ${dorayakis.join("")}
		</div>
    ${pagination.render()}
	`;

    target.innerHTML = components;
  } catch (err) {
    console.log("KE CATRCH GAN");
    const components = `
      ${generateNavbar()}
      ${searchBar.render()}
      <div class="search-container">
        DORAYAKI NOT FOUND :(
      </div>
    `;

    target.innerHTML = components;
  }
};

const HistoryPage = async () => {
  const user = await userRoute();
  const target = document.getElementById("history");
  const url = new URL(window.location.href);
  const page = parseInt(url.searchParams.get("page")) || 1;
  let histories = [];
  let res = "[]";
  let data = [];
  try {
    res = await getOrderPage(page);
  } catch (err) {
    console.log(err);
  }

  data = JSON.parse(res);
  console.log(data.entries);
  if (data.entries && data.entries.length) {
    data.entries?.map((row) => {
      console.log(row.createdAt.values);
      histories.push(HistoryCard(row.createdAt, row.dorayaki, row.total_cost));
    });
  }

  const pagination = new Pagination("pagination", page, data["page_count"], "");

  const components = `
  ${generateNavbar()}
  <div class="history-container">
    ${pageTitle("Riwayat Pembelian")}
    <div class="history-inner-container">
      ${
        histories.length
          ? histories.join("")
          : "<div class='not-found-container'>History is empty</div>"
      }
    </div>
    ${pagination.render()}
  </div>
`;

  target.innerHTML = components;
};

const BuyPage = async () => {
  await userRoute();

  const target = document.getElementById("buy");
  const modaldom = document.getElementById("modal-portal");

  const url = new URL(window.location.href);
  const id = url.searchParams.get("id");
  const counter_id = "counter";

  let res;
  let data;
  let prevData = null;

  const interval = setInterval(async () => {
    try {
      res = await getDorayakiDetail(id);
      data = JSON.parse(res);
    } catch (e) {
      clearInterval(interval);
    }

    if (JSON.stringify(data) !== JSON.stringify(prevData)) {
      prevData = data;
      render();
    }
  }, 2000);

  const counter_cb = (val) => `
    const total = document.getElementById("total");
    total.innerHTML = formatCurrency(${val} * ${data.price});
  `;
  const counter = new Counter(counter_id, counter_cb);
  const createModal = (message) => {
    return new Modal(
      "confirm-purchase",
      false,
      message
    )
  }

  const successModal = createModal(
    "<h3>Dorayaki berhasil dibeli!</h3>"
  );

  const onSubmit = `async function start() {
    const res = await buyDorayaki("${id}","${counter_id}");
    if (res) {
      ${successModal.open()}
      redirect("/history",1000);
    }
  }
  start();
  `;

  const onCancel = `redirect("/home")`;

  function render() {
    const components = `
      ${generateNavbar()}
      ${pageTitle("Pemesanan")}
      <div class="buy-container">
        <div class="detail">
          <img class="dorayaki-image" src="${data.thumbnail}">
        </div>
        <div class="form">
          <h5 class="dorayaki-name">${data.name}</h5>
          <p>${data.description}</p>
          <p>Available stocks: ${data.stock}</p>
          <h4 class="dorayaki-price">${formatCurrency(data.price)}</h4>
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
  }

  render();

  modaldom.innerHTML = successModal.render();
};
