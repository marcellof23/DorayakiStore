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

  const components = `
		${generateNavbarAdmin()}
		<div class="dorayaki-management-container">
			${pageTitle("Dorayaki Management")}
      <div class="search-container">
        ${SearchBar()}
        <button class="add-dorayaki">
          Add Dorayaki
        </button>
      </div>
      <div class="table-container">
       ${generate_table()}
       <div class="pagination-container">
        <  1 > 
      </div>
      </div>
      
		</div>
	`;

  target.innerHTML = components;
};
