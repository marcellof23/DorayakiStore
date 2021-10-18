const AdminHomePage = async () => {
  const target = document.getElementById("home-admin");

  async function fetchingData() {
    const axois = new AXOIS("/");
    const res = await axois.get("api/dorayaki/get-pagination?page=1");
    return res;
  }

  const res = await fetchingData();

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
       ${generate_table(res)}
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
      <div class="dorayaki-details">
        <img src="" alt="foto dorayaki" id="dorayaki-photo" />
        <div class="dorayaki-details-main">
          <div class="dorayaki-details-text">
            <h3>Name</h3>
            <span>{name}</span>
          </div>
          <div class="dorayaki-details-text">
            <h3>Price</h3>
            <span>{price}</span>
          </div>
          <div class="dorayaki-details-text">
            <h3>Stock</h3>
            <span>{stock}</span>
          </div>
          <div class="dorayaki-details-text" style="margin-bottom:10px">
            <h3>Description</h3>
            <p>{description}</p>
          </div>
          <button class="dorayaki-button primary">Edit Dorayaki</button>
          <button class="dorayaki-button outline">Delete Dorayaki</button>
        </div>
      </div>
		</div>
	`;

  target.innerHTML = components;
};

const DorayakiEditPage = () => {
  const target = document.getElementById("dorayaki-edit-page");

  const components = `
		${generateNavbarAdmin()}
		<div class="dorayaki-management-container">
			${pageTitle("Dorayaki Management")}
      <div class="dorayaki-details">
        <img src="" alt="foto dorayaki" id="dorayaki-photo" />
        <form class="dorayaki-details-main">
          <div class="dorayaki-details-text">
            <h3>Name</h3>
            <input name="name" value="{name}" />
          </div>
          <div class="dorayaki-details-text">
            <h3>Price</h3>
            <input name="price" type="number" />
          </div>
          <div class="dorayaki-details-text">
            <h3>Stock</h3>
            <input name="stock" type="number" />
          </div>
          <div class="dorayaki-details-text" style="margin-bottom:10px">
            <h3>Description</h3>
            <textarea name="description" rows="4" cols="50"></textarea>
          </div>
          <input type="submit" class="dorayaki-button primary" value="Save changes" />
          <button class="dorayaki-button outline">Cancel</button>
        </form>
      </div>
		</div>
	`;

  target.innerHTML = components;
};

const DorayakiAddPage = () => {
  const target = document.getElementById("dorayaki-add-page");

  const components = `
		${generateNavbarAdmin()}
		<div class="dorayaki-management-container">
			${pageTitle("Dorayaki Management")}
      <div class="dorayaki-details">
        <img src="" alt="foto dorayaki" id="dorayaki-photo" />
        <form class="dorayaki-details-main">
          <div class="dorayaki-details-text">
            <h3>Name</h3>
            <input name="name" value="{name}" />
          </div>
          <div class="dorayaki-details-text">
            <h3>Price</h3>
            <input name="price" type="number" />
          </div>
          <div class="dorayaki-details-text">
            <h3>Stock</h3>
            <input name="stock" type="number" />
          </div>
          <div class="dorayaki-details-text" style="margin-bottom:10px">
            <h3>Description</h3>
            <textarea name="description" rows="4" cols="50"></textarea>
          </div>
          <input type="submit" class="dorayaki-button primary" value="Add new dorayaki" />
          <button class="dorayaki-button outline">Cancel</button>
        </form>
      </div>
		</div>
	`;

  target.innerHTML = components;
};
