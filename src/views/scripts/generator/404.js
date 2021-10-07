function generate404Page() {
	const img = `<img src=${PUBLIC_ENDPOINT}/asset/alert-circle.svg>`;
	const text = `<h1>Book not found!</h1>`;
	const alertContainer = `<div class="alert">${img}${text}</div>`;
	return alertContainer;
}
