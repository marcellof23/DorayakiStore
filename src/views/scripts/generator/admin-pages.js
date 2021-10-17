const AdminHomePage = () => {
  const target = document.getElementById("home-admin");

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
        <p class="pagination-number">< 1 ></p>
      </div>
      </div>
      
		</div>
	`;

  target.innerHTML = components;
};
