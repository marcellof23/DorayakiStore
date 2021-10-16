const HomePage = () => {
  const target = document.getElementById("home");

  const components = `
		${generateNavbar()}
		${SearchBar()}
		<div class="home-container">
		</div>
	`;

  target.innerHTML = components;
};

const SearchPage = () => {
  const target = document.getElementById("search");

  const components = `
		${generateNavbar()}
		${SearchBar()}
		<div class="search-container">
		</div>
	`;

  target.innerHTML = components;
};

const HistoryPage = () => {
  const target = document.getElementById("history");

  const data = [
    {
      pic: "https://picsum.photos/200",
      createdAt: new Date(),
      title: "Dorayaki spesial",
      amount: 180,
    },
    {
      pic: "https://picsum.photos/200",
      createdAt: new Date(),
      title: "Dorayaki spesial",
      amount: 180,
    },
  ];

  const histories = data.map((row) =>
    HistoryCard(row.pic, row.createdAt, row.title, row.amount)
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
