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

const DorayakiDetailsPage = async () => {
	const target = document.getElementById("dorayaki-details-page");

	const url = new URL(window.location.href);
	const id = parseInt(url.searchParams.get("id"));

	const res = await axois.get(`dorayaki/get-details?dorayaki_id=${id}`);
	const data = JSON.parse(res);
	const {name, price, stock, description, thumbnail} = data;

	const onEdit = `redirect("/admin/dorayaki-edit?id=${id}")`;

	const ddt = "dorayaki-details-text";

	const components = `
		${generateNavbarAdmin()}
		<div class="dorayaki-management-container">
			${pageTitle("Dorayaki Management")}
      <div class="dorayaki-details">
        ${Image(thumbnail || "", false, "foto dorayaki", "dorayaki-photo")}
        <div class="dorayaki-details-main">
          ${LabText("Name", "name", name, true, "text", `${ddt} name`)}
          ${LabText("Price", "price", price, true, "text", `${ddt} price`)}
          ${LabText("Stock", "stock", stock, true, "text", `${ddt} stock`)}
          ${LabText(
						"Description",
						"description",
						description,
						true,
						"text",
						`${ddt} description`
					)}
          ${Button("Edit Dorayaki", true, onEdit)}
          ${Button("Delete Dorayaki", false, `deleteDorayaki(${id})`)}
        </div>
      </div>
		</div>
	`;

	target.innerHTML = components;
};

const DorayakiEditPage = async () => {
	const target = document.getElementById("dorayaki-edit-page");

	const url = new URL(window.location.href);
	const id = parseInt(url.searchParams.get("id"));

	const res = await axois.get(`dorayaki/get-details?dorayaki_id=${id}`);
	const data = JSON.parse(res);
	const {name, price, stock, description, thumbnail} = data;
	const ddt = "dorayaki-details-text";

	onEdit = `updateDorayaki(${id})`;

	onCancel = `redirect("/admin/dorayaki-details?id=${id}")`;

	const components = `
		${generateNavbarAdmin()}
		<div class="dorayaki-management-container">
			${pageTitle("Dorayaki Management")}
      <div class="dorayaki-details">
        ${Image(thumbnail || "", true, "foto dorayaki", "dorayaki-photo")}
        <form class="dorayaki-details-main">
          ${LabText("Name", "name", name, false, "text", `${ddt} name`)}
          ${LabText("Price", "price", price, false, "text", `${ddt} price`)}
          ${LabText("Stock", "stock", stock, false, "text", `${ddt} stock`)}
          ${LabText(
						"Description",
						"description",
						description,
						false,
						"text",
						`${ddt} description`
					)}
          ${Button("Save changes", true, onEdit)}
          ${Button("Cancel", false, onCancel)}
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