const AdminHomePage = () => {
  const target = document.getElementById("home-admin");

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
		${generateNavbarAdmin()}
		<div class="history-container">
			${pageTitle("Riwayat Pembelian")}
			${histories.join("")}
		</div>
	`;

  target.innerHTML = components;
};
