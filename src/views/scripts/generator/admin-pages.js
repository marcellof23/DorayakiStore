const AdminHomePage = async () => {
	const target = document.getElementById("home-admin");

	const table_id = "dorayaki-table";

	const head = {
		No: "No",
		thumbnail: "Thumbnail",
		name: "Nama Dorayaki",
		description: "Deskripsi",
		price: "Harga",
		stock: "Stock",
	};

	const table = new Table(table_id, head, getDorayakiPage);

	const onAdd = `redirect("/admin/dorayaki-add")`;

	const components = `
    ${generateNavbarAdmin()}
    <div class="dorayaki-management-container">
      ${pageTitle("Dorayaki Management")}
      <div class="search-container">
        ${SearchBar()}
        ${Button("Add Dorayaki", "primary", onAdd)}
      </div>
      ${await table.generate_table()}
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
          <div class="dorayaki-details-text name">
            <h3>Name</h3>
            <span>{name}</span>
          </div>
          <div class="dorayaki-details-text price">
            <h3>Price</h3>
            <span>{price}</span>
          </div>
          <div class="dorayaki-details-text stock">
            <h3>Stock</h3>
            <span>{stock}</span>
          </div>
          <div class="dorayaki-details-text description" style="margin-bottom:10px">
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
          <div class="dorayaki-details-text name">
            <h3>Name</h3>
            <input name="name" value="{name}" />
          </div>
          <div class="dorayaki-details-text price">
            <h3>Price</h3>
            <input name="price" type="number" />
          </div>
          <div class="dorayaki-details-text stock">
            <h3>Stock</h3>
            <input name="stock" type="number" />
          </div>
          <div class="dorayaki-details-text description" style="margin-bottom:10px">
            <h3>Description</h3>
            <textarea name="description" rows="4" cols="50"></textarea>
          </div>
          <button class="dorayaki-button primary">Save Changes</button>
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
          <div class="dorayaki-details-text name">
            <h3>Name</h3>
            <input name="name" />
          </div>
          <div class="dorayaki-details-text price">
            <h3>Price</h3>
            <input name="price" type="number" />
          </div>
          <div class="dorayaki-details-text stock">
            <h3>Stock</h3>
            <input name="stock" type="number" />
          </div>
          <div class="dorayaki-details-text description" style="margin-bottom:10px">
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

const AdminHistoryPage = async () => {
	const target = document.getElementById("admin-history-page");

	const url = new URL(window.location.href);
	const type = url.searchParams.get("type") || "user";

	const table_id =
		type === "user" ? "user-pov-history-table" : "admin-pov-history-table";

	const head = {
		No: "No",
		createdAt: "Tanggal",
		user: "User",
		dorayaki: "Dorayaki",
		amount: "Quantity",
		total_cost: "Total",
	};

	const adminHead = {
		No: "No",
		createdAt: "Tanggal",
		user: "User",
		dorayaki: "Dorayaki",
		amount: "Quantity",
		type: "Type",
		total_cost: "Total",
	};

	const table = new Table(
		table_id,
		type === "user" ? head : adminHead,
		getOrderPage
	);

	const components = `
    ${generateNavbarAdmin()}
    <div class="history-container">
      ${pageTitle("Dorayaki Order List")}
      <div class="control-container">
      </div>
      ${await table.generate_table()}
    </div>
  `;
	target.innerHTML = components;
};