class Table {
	constructor(table_id, head, onGet) {
		const params = new URLSearchParams(window.location.search);
		this.table_id = table_id;
		this.pagination_id = `${table_id}-pagination`;
		this.head = head;
		this.onGet = onGet;
		this.page = parseInt(params.get("page")) || 1;
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

		data.forEach((row, i) => {
			const url =
				location.protocol +
				"//" +
				location.host +
				`/admin/dorayaki-details?id=${row.dorayaki_id}`;
			const onclick = `window.location.href="${url}"`;
			let row_data = `<tr class="table-row" onclick='${onclick}'><td>${
				i + 1
			}</td>`;

			for (const [key, _] of Object.entries(this.head)) {
				if (key === "No") continue;
				if (key === "thumbnail") {
					row_data += `<td class="table-data"><img src="${row[key]}"/></td>`;
				} else {
					row_data += `<td class="table-data">${row[key]}</td>`;
				}
			}

			row_data += "</tr>";
			table_data += row_data;
		});

		return table_data;
	};

	async generate_table() {
		const data = JSON.parse(await this.onGet(this.page));

		console.log(data);

		const table_headings = this.generate_heading();
		const table_body = this.generate_body(data.entries);

		const url = location.protocol + "//" + location.host + location.pathname;
		const onPrev = `window.location.href="${url}?page=${this.page - 1}"`;
		const onNext = `window.location.href="${url}?page=${this.page + 1}"`;

		return `
      <div class="table-container">
        <table class="table" id=${this.table_id}>
          ${table_headings}
          ${table_body}
        </table>
        <div class="pagination-container">
          ${
						this.page === 1
							? "<div></div>"
							: `<div class="pagination-btn" onclick='${onPrev}'> < </div>`
					}
          <p id="${this.pagination_id}" class="pagination-number">${
			this.page
		}</p> 
          ${
						this.page === data.page_count
							? ""
							: `<div class="pagination-btn" onclick='${onNext}'> > </div>`
					}
          
        </div>
      </div>`;
	}
}
