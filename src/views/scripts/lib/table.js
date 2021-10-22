class Table {
	constructor(
		table_id,
		head,
		onGet,
		urlOnClick,
		id_field,
		isClickable = true,
		otherParams = "",
		withTopPagination = false
	) {
		const params = new URLSearchParams(window.location.search);
		this.table_id = table_id;
		this.pagination_id = `${table_id}-pagination`;
		this.head = head;
		this.data = [];
		this.onGet = onGet;
		this.urlOnClick = urlOnClick;
		this.id_field = id_field;
		this.isClickable = isClickable;
		this.page = parseInt(params.get("page")) || 1;
		this.otherParams = otherParams;
		this.withTopPagination = withTopPagination;
	}

	generate_heading() {
		let table_headings = `<tr><th class="table-data first-row">No</th>`;

		for (const [key, value] of Object.entries(this.head)) {
			if (key === "No") continue;
			table_headings += `<th class="table-data">${value}</th>`;
		}

		table_headings += `</tr>`;

		return table_headings;
	}

	generate_body = (data) => {
		let table_data = "";

		console.log(this.data);
		console.log(this.page, this.data.items_per_page);

		data.forEach((row, i) => {
			const url = `${location.protocol}//${location.host}${
				this.urlOnClick
			}?id=${row[this.id_field]}`;

			const onclick = this.isClickable ? `window.location.href="${url}"` : "";

			let row_data = `<tr class="table-row ${
				this.isClickable ? "clickable" : ""
			}" onclick='${onclick}'><td>${
				i + 1 + (this.page - 1) * this.data.items_per_page
			}</td>`;

			for (const [key, _] of Object.entries(this.head)) {
				if (key === "No") continue;
				if (key === "thumbnail") {
					row_data += `<td class="table-data"><img src="${
						row[key] || "/public/placeholder.jpg"
					}"/></td>`;
				} else {
					row_data += `<td class="table-data">${truncate(row[key], 15)}</td>`;
				}
			}

			row_data += "</tr>";
			table_data += row_data;
		});

		return table_data;
	};

	async init() {
		const data = JSON.parse(await this.onGet(this.page));
		this.data = data;
	}

	async generate_table() {
		try {
			const table_headings = this.generate_heading();
			const table_body = this.generate_body(this.data.entries, this.data);

			const pagination = new Pagination(
				this.pagination_id,
				this.page,
				this.data.page_count,
				this.otherParams
			);

			return `
      ${
				this.withTopPagination
					? `<div class="pagination-container">
        ${pagination.render()}
      </div>`
					: ``
			}
      <div class="table-container">
        <table class="table" id=${this.table_id}>
          ${table_headings}
          ${table_body}
        </table>
        <div class="pagination-container">
          ${pagination.render()}
        </div>
      </div>`;
		} catch (err) {
			console.log(err);
		}
	}
}
