const FE_BASE_URL = "";
const PUBLIC_URL = "/public";

function constructURL(url) {
	return `${FE_BASE_URL}${url}`;
}

function constructPublicURL(url) {
	return `${PUBLIC_URL}/${url}`;
}
