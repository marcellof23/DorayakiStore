const HistoryCard = (createdAt, name, amount) => {
  const timestamp = `<small class="history-time">${getDuration(
    createdAt
  )}</small>`;
  const judul = `<p class="history-title">${name}</p>`;
  const jumlah = `<h3 class="history-amount">${formatCurrency(amount)}</h3>`;

  return `
	<div class="history-card">
		${timestamp}
    ${judul}
    ${jumlah}
	</div>
	`;
};

const DorayakiCard = (thumbnail, price, name, id) => {
  const pic = `<img src="${thumbnail}" class="dorayaki-img" alt="gambar-dorayaki"/>`;
  const text = `<div class="dorayaki-text">
		<p class="dorayaki-name">${name}</p>
		<h3 class="dorayaki-price">${formatCurrency(price)}</h3>
	</div>`;
  const cart_icon = `<div class="dorayaki-cart-icon-container" onclick="redirect('/buy?id=${id}')">
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
