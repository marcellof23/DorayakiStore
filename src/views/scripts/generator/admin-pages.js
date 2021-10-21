const AdminHomePage = async () => {
	await adminRoute();

	const target = document.getElementById("home-admin");

	const table_id = "dorayaki-table";

	const searchBar = new SearchBar("search-box", "/admin/dorayaki");

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
	
	async function render() {
		const components = `
		${generateNavbarAdmin()}
			<div class="dorayaki-management-container">
				${pageTitle("Dorayaki Management")}
				<div class="search-container">
					${searchBar.render()}
					${Button("Add Dorayaki", "primary", onAdd)}
				</div>
				${await table.generate_table()}
			</div>
		`;
		target.innerHTML = components;
	}
	
	const interval = setInterval(async () => {
		const data = JSON.parse(
			await table.onGet(table.page)
		);
			
		if (JSON.stringify(data) !== JSON.stringify(table.data)) {			
			table.data = data;
			await render();
		}
	}, 2000);
	
	try {
		await table.init();
		await render();
	} catch (err) {
		clearInterval(interval);
		const components = `
		${generateNavbarAdmin()}
			<div class="dorayaki-management-container">
				${pageTitle("Dorayaki Management")}
				<div class="search-container">
					${searchBar.render()}
					${Button("Add Dorayaki", "primary", onAdd)}
				</div>
				<span>No data found</span>
			</div>
		`;
		target.innerHTML = components;
	}
};

const DorayakiDetailsPage = async () => {
	await adminRoute();

	const target = document.getElementById("dorayaki-details-page");
	const modaldom = document.getElementById("modal-portal");

	const url = new URL(window.location.href);
	const id = parseInt(url.searchParams.get("id"));

	try {
		const res = await getDorayakiDetail(id);
		const data = JSON.parse(res);
		const {name, price, stock, description, thumbnail} = data;

		const ddt = "dorayaki-details-text";

		const onEdit = `redirect("/admin/dorayaki-edit?id=${id}")`;
		const onDelete = `deleteDorayaki(${id})`;

		const modal = new ConfirmationModal(
			"confirm-delete",
			false,
			onDelete,
			null,
			"Apakah anda yakin akan menghapus dorayaki ini?"
		);

		const components = `
		${generateNavbarAdmin()}
		<div class="dorayaki-management-container">
			${pageTitle("Dorayaki Management")}
      <div class="dorayaki-details">
        ${Image(
					thumbnail || "/public/placeholder.jpg",
					false,
					"foto dorayaki",
					"dorayaki-photo"
				)}
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
          ${Button("Delete Dorayaki", false, modal.open())}
        </div>
      </div>
		</div>
	`;

		target.innerHTML = components;
		modaldom.innerHTML = modal.render();
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
	await adminRoute();

	const target = document.getElementById("dorayaki-edit-page");

	const url = new URL(window.location.href);
	const id = parseInt(url.searchParams.get("id"));

	const res = await getDorayakiDetail(id);
	const data = JSON.parse(res);
	const {name, price, stock, description, thumbnail} = data;
	const ddt = "dorayaki-details-text";

	onSubmit = `updateDorayaki(${id})`;
	onCancel = `redirect("/admin/dorayaki-details?id=${id}")`;

	const components = `
		${generateNavbarAdmin()}
		<div class="dorayaki-management-container">
			${pageTitle("Dorayaki Management")}
      <div class="dorayaki-details">
        ${Image(
					thumbnail || "/public/placeholder.jpg",
					true,
					"foto dorayaki",
					"dorayaki-photo"
				)}
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

const DorayakiAddPage = async () => {
	const target = document.getElementById("dorayaki-add-page");
	const modaldom = document.getElementById("modal-portal");

	await adminRoute();

	const modal = new Modal("confirm-delete", false, "Dorayaki berhasil dibuat!");

	onSubmit = `createDorayaki(); ${modal.open()}; redirect("/admin/dorayaki",1000)`;
	onCancel = `redirect("/admin/dorayaki")`;

	const ddt = "dorayaki-details-text";

	const components = `
		${generateNavbarAdmin()}
		<div class="dorayaki-management-container">
			${pageTitle("Dorayaki Management")}
      <div class="dorayaki-details">
        ${Image(
					"/public/placeholder.jpg",
					true,
					"foto dorayaki",
					"dorayaki-photo"
				)}
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
	modaldom.innerHTML = modal.render();
};

const AdminHistoryPage = async () => {
	const target = document.getElementById("admin-history-page");

	await adminRoute();

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
		false,
		`&type=${type}`
	);

	const switchOptions = ["user", "admin"];
	const active = type;

	async function render() {
		const components = `
			${generateNavbarAdmin()}
			<div class="history-container">
				${pageTitle("Dorayaki Order List")}
				${Switch(switchOptions, active, "/admin/history", "type")}
				${await table.generate_table()}
			</div>
		`;
		target.innerHTML = components;
	}

	const interval = setInterval(async () => {
		const data = JSON.parse(
			await table.onGet(table.page)
		);

		if (JSON.stringify(data) !== JSON.stringify(table.data)) {
			table.data = data;
			await render();
		}
	}, 2000);

	try {
		await table.init();
		await render();
	} catch (err) {
		clearInterval(interval)

		const components = `
			${generateNavbarAdmin()}
			<div class="history-container">
				${pageTitle("Dorayaki Order List")}
				${Switch(switchOptions, active, "/admin/history", "type")}
				<span>No data found</span>
			</div>
		`;
		target.innerHTML = components;
	}
};
