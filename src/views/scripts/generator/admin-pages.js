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

	const onEdit = `redirect("/admin/dorayaki-edit?id=${id}")`;
	const onDelete = `openTab("/")`;

	const components = `
		${generateNavbarAdmin()}
		<div class="dorayaki-management-container">
			${pageTitle("Dorayaki Management")}
      <div class="dorayaki-details">
        ${Image(data.thumbnail || "", false, "foto dorayaki", "dorayaki-photo")}
        <div class="dorayaki-details-main">
          ${LabText(
						"Name",
						data.name || "name",
						true,
						"text",
						"dorayaki-details-text name"
					)}
          ${LabText(
						"Price",
						data.price || "price",
						true,
						"text",
						"dorayaki-details-text price"
					)}
          ${LabText(
						"Stock",
						data.stock || "stock",
						true,
						"text",
						"dorayaki-details-text stock"
					)}
          ${LabText(
						"Description",
						data.description || "description",
						true,
						"text",
						"dorayaki-details-text description"
					)}
          ${Button("Edit Dorayaki", true, onEdit)}
          ${Button("Delete Dorayaki", false, onDelete)}
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