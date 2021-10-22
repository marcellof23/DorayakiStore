//all css must be defined on control.css

class SearchBar {
  constructor(id, targetURL) {
    this.id = id;
    this.targetURL = targetURL;
    this.icon = constructPublicURL("icons/search-primary.svg");
    const url = new URL(window.location.href);
    const q = url.searchParams.get("query");
    this.value = q || "";
  }

  onChange() {
    return `searchDorayaki("${this.id}","${this.targetURL}")`;
  }

  render() {
    return `<div class='searchbox'>
      <input id="${
        this.id
      }" type="text" class="search-input" onChange='${this.onChange()}' value="${
      this.value
    }"/>
      <img src=${this.icon} alt="search-icon" class="search-icon"/>
    </div>`;
  }
}

class Counter {
  constructor(id, cb) {
    this.id = id;
    this.cb = cb;
  }

  onAdd() {
    return `
      const dom = document.getElementById("${this.id}");
      const val = parseInt(dom.innerHTML) + 1;
      dom.innerHTML = val;
      ${this.cb("val")};
    `;
  }

  onMin() {
    return `
      const dom = document.getElementById("${this.id}");
      let val = parseInt(dom.innerHTML);
      val =(val-1 > 0) ? val-1 : val;
      dom.innerHTML = val;
      ${this.cb("val")}
    `;
  }

  getValue() {
    return `
      const dom = document.getElementById("${this.id}");
      let val = parseInt(dom.innerHTML);
      return val;
    `;
  }

  render() {
    return `
      <div class='counter'>
        <h3 onclick='${this.onMin()}'>-</h3>
        <div id='${this.id}'>1</div>
        <h3 onclick='${this.onAdd()}'>+</h3>
      </div>
    `;
  }
}

const LabText = (
  label,
  name,
  value,
  isDisabled = false,
  input_type,
  classname
) =>
  `
    <div class="labtext ${isDisabled ? "disabled" : ""} ${classname}">
      <label>${label}</label>
      ${
        isDisabled
          ? `<span>${value}</span>`
          : input_type == "textarea"
          ? `<textarea name="${name}" rows="4" cols="50">${value}</textarea>`
          : `<input type=${input_type} value="${value}" name="${name}"/>`
      }
      
    </div>
  `;

const Button = (text, isPrimary = true, onclick, isSubmit = false) =>
  isSubmit
    ? `<input type="submit"  class="btn btn-${
        isPrimary ? "primary" : "secondary"
      }" value='${text}'/>`
    : `
    <button type="button" onclick='${onclick}' class="btn btn-${
        isPrimary ? "primary" : "secondary"
      }">
      ${text}
    </button>
  `;

const Image = (url, isUpload, alt, id) =>
	`
    <div class="image-container" onclick="${
			isUpload
				? `handleUploadPhoto((file) => {
				document.querySelector('#${id}').src = \`/public/upload/\${file.name}\`
			})`
				: `openTab('${url}')`
		}">
      <img alt="${alt}" src="${url}" id="${id}"/>
    </div>
  `;

const Alert = (type, text, classname = "") =>
  `
    <div class="alert ${type} ${classname}">
      ${text}
    </div>
`;

const ShowAlert = (type, text, classname, appendType, parentClass) => {
  const parentEl = document.querySelector(`.${parentClass}`);
  const oldAlert = document.querySelector(`.alert`);
  if (oldAlert) {
    oldAlert.classList = `alert ${type} ${classname}`;
    oldAlert.textContent = text;
  } else {
    parentEl.insertAdjacentHTML(appendType, Alert(type, text, classname));
  }
};

const Switch = (options, active, baseUrl, queryParam) => {
  let opts = "";
  options.forEach((element) => {
    opts += `<div class="option ${
      element === active ? "active" : ""
    }" onclick='redirect("${baseUrl}?${queryParam}=${element}")'>${element}</div>`;
  });
  return `
  <div class="switch">
    ${opts}
  </div>
  `;
};

class Pagination {
  constructor(id, page = 0, page_count = 0, otherParams) {
    this.id = id;
    this.page = page;
    this.page_count = page_count;
    this.otherParams = otherParams;
    this.url = location.protocol + "//" + location.host + location.pathname;
  }

  onPrev = () =>
    `window.location.href="${this.url}?page=${this.page - 1}${
      this.otherParams
    }"`;

  onNext = () =>
    `window.location.href="${this.url}?page=${this.page + 1}${
      this.otherParams
    }"`;

  render() {
    return `
				<div class='pagination-container'>
					${
            this.page === 1
              ? "<div></div>"
              : `<div class="pagination-btn" onclick='${this.onPrev()}'> < </div>`
          }
          <p id="${this.pagination_id}" class="pagination-number">${
      this.page
    }</p>
          ${
            this.page >= this.page_count
              ? ""
              : `<div class="pagination-btn" onclick='${this.onNext()}'> > </div>`
          }
				</div>
			`;
  }
}
