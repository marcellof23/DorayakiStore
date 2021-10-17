const AdminHomePage = () => {
  const target = document.getElementById("home-admin");

  const components = `
		${generateNavbarAdmin()}
		<div class="dorayaki-management-container">
			${pageTitle("Dorayaki Management")}
      <div class="search-container">
        ${SearchBar()}
        <button onclick="submit" class="add-dorayaki">
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

const DorayakiDetailsPage = () => {
  const target = document.getElementById("dorayaki-details-page");

  const components = `
		${generateNavbarAdmin()}
		<div class="dorayaki-management-container">
			${pageTitle("Dorayaki Management")}
      <div class="doriyaki-details">
        <img src="" alt="foto doriyaki" id="dorayaki-photo" />
        <div class="doriyaki-details-main">
          <div class="doriyaki-details-text">
            <h3>Name</h3>
            <span>{name}</span>
          </div>
          <div class="doriyaki-details-text">
            <h3>Price</h3>
            <span>{price}</span>
          </div>
          <div class="doriyaki-details-text">
            <h3>Stock</h3>
            <span>{stock}</span>
          </div>
          <div class="doriyaki-details-text" style="margin-bottom:10px">
            <h3>Description</h3>
            <p>{description}</p>
          </div>
          <button class="doriyaki-button primary">Edit Doriyaki</button>
          <button class="doriyaki-button outline">Delete Doriyaki</button>
        </div>
      </div>
		</div>
	`;

  target.innerHTML = components;
}