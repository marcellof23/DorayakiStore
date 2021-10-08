const FE_BASE_URL = "/src/views";
const PUBLIC_URL = "/src/public";

function constructURL(url) {
  return `${FE_BASE_URL}${url}.php`;
}

function constructPublicURL(url) {
  return `${PUBLIC_URL}/${url}`;
}
