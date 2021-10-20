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

  const table = new Table(
    table_id,
    head,
    getDorayakiPage,
    "/admin/dorayaki-details",
    "dorayaki_id"
  );

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

  try {
    const res = await getDorayakiDetail(id);
    const data = JSON.parse(res);
    const { name, price, stock, description, thumbnail } = data;

    const onEdit = `redirect("/admin/dorayaki-edit?id=${id}")`;

    const ddt = "dorayaki-details-text";

    const components = `
		${generateNavbarAdmin()}
		<div class="dorayaki-management-container">
			${pageTitle("Dorayaki Management")}
      <div class="dorayaki-details">
        ${Image(thumbnail || "/public/placeholder.jpg", false, "foto dorayaki", "dorayaki-photo")}
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
  } catch (err) {
    console.log(err);
    const components = `
      ${generateNavbarAdmin()}
      <div class="dorayaki-management-container">
        ${pageTitle("Dorayaki Management")}
        <div class="dorayaki-details">
          ${Alert("error", err.response, "col-2")}
        </div>
      </div>
    `;

    target.innerHTML = components;
  }
};

const DorayakiEditPage = async () => {
  const target = document.getElementById("dorayaki-edit-page");

  const url = new URL(window.location.href);
  const id = parseInt(url.searchParams.get("id"));

  const res = await getDorayakiDetail(id);
  const data = JSON.parse(res);
  const { name, price, stock, description, thumbnail } = data;
  const ddt = "dorayaki-details-text";

  onSubmit = `updateDorayaki(${id})`;
  onCancel = `redirect("/admin/dorayaki-details?id=${id}")`;

  const components = `
		${generateNavbarAdmin()}
		<div class="dorayaki-management-container">
			${pageTitle("Dorayaki Management")}
      <div class="dorayaki-details">
        ${Image(thumbnail || "/public/placeholder.jpg", true, "foto dorayaki", "dorayaki-photo")}
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
          ${Button("Save changes", true, onSubmit)}
          ${Button("Cancel", false, onCancel)}
        </form>
      </div>
		</div>
	`;

  target.innerHTML = components;
};

const DorayakiAddPage = () => {
  const target = document.getElementById("dorayaki-add-page");

  onSubmit = `createDorayaki()`;
  onCancel = `redirect("/admin/dorayaki")`;

  const ddt = "dorayaki-details-text";

  const components = `
		${generateNavbarAdmin()}
		<div class="dorayaki-management-container">
			${pageTitle("Dorayaki Management")}
      <div class="dorayaki-details">
        ${Image("/public/placeholder.jpg", true, "foto dorayaki", "dorayaki-photo")}
        <form class="dorayaki-details-main">
          ${LabText("Name", "name", "", false, "text", `${ddt} name`)}
          ${LabText("Price", "price", "", false, "text", `${ddt} price`)}
          ${LabText("Stock", "stock", "", false, "text", `${ddt} stock`)}
          ${LabText(
            "Description",
            "description",
            "",
            false,
            "text",
            `${ddt} description`
          )}
          ${Button("Add New Dorayaki", true, onSubmit)}
          ${Button("Cancel", false, onCancel)}
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
    getOrderPage,
    "",
    "",
    false
  );

  const switchOptions = ["user", "admin"];
  const active = type;

  const components = `
    ${generateNavbarAdmin()}
    <div class="history-container">
      ${pageTitle("Dorayaki Order List")}
      ${Switch(switchOptions, active, "/admin/history", "type")}
      ${await table.generate_table()}
    </div>
  `;
  target.innerHTML = components;
};
