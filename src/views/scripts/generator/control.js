//all css must be defined on control.css

const SearchBar = (onchange) =>
	`<div class='searchbox'>
		<input type="text" class="search-input" onchange='debounce(${onchange})'/>
		<img src=${constructPublicURL(
			"icons/search-primary.svg"
		)} alt="search-icon" class="search-icon"/>
	</div>`;


// type consist of : "input" : "disabled"
const LabText = (label, value, isDisabled = false, input_type, classname) =>
	`
    <div class="labtext ${isDisabled ? "disabled" : ""} ${classname}">
      <label>${label}</label>
      ${isDisabled?
        `<span>${value}</span>`:
        `<input type=${input_type} value="${value}"/>`
      }
      
    </div>
  `;

const Button = (text, isPrimary=true, onclick) =>
	`
    <button onclick='${onclick}' class="btn btn-${isPrimary?"primary":"secondary"}">
      ${text}
    </button>
  `;

const Image = (url, isUpload, alt, id) =>
	`
    <div class="image-container" onclick="${
			isUpload ? "handleUploadPhoto(()=>{})" : `openTab("${url}")`
		}">
      <img alt="${alt}" src="${url}" id="${id}"/>
    </div>
  `;