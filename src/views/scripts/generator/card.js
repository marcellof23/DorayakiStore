const HistoryCard = (createdAt, name, amount) => {
	const timestamp = `<small class="history-time">${getDuration(
		createdAt
	)}</small>`;
	const judul = `<p class="history-title">${name}</p>`;
	const jumlah = `<h3 class="history-amount">IDR ${amount}</h3>`;

	return `
	<div class="history-card">
		${timestamp}
    ${judul}
    ${jumlah}
	</div>
	`;
};

const DorayakiCard = (thumbnail, price, name) => {
	const pic = `<img src="${thumbnail}" class="dorayaki-img" alt="gambar-dorayaki"/>`;
	const text = `<div class="dorayaki-text">
		<p class="dorayaki-name">${name}</p>
		<h2 class="dorayaki-price">${price}</h2>
	</div>`;
	const cart_icon = `<div class="dorayaki-cart-icon-container">
			<img class="dorayaki-cart-icon" src="${constructPublicURL("icons/cart.svg")}"/>
		</div>
	`;

	return `
		<div class="dorayaki-card">
			${pic}
			<div class="dorayaki-control">
				${text}
				${cart_icon}
			</div>
		</div>
	`;
};
