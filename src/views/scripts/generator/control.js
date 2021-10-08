//all css must be defined on control.css

const SearchBar = (onchange) =>
	`<div class='searchbox'>
		<input type="text" class="search-input" onchange='debounce(${onchange})'/>
		<img src=${constructPublicURL(
			"icons/search-primary.svg"
		)} alt="search-icon" class="search-icon"/>
	</div>`;
