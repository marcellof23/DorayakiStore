const HistoryCard = (picture, createdAt, title, amount) => {
	const pic = `<img src="${picture}" class="history-img" alt="gambar-dorayaki"/>`;
	const timestamp = `<small class="history-time">${getDuration(
		createdAt
	)}</small>`;
	const judul = `<p class="history-title">${title}</p>`;
	const jumlah = `<h3 class="history-amount">IDR ${amount}</h3>`;

	return `
	<div class="history-card">
		<div class="left">
			${pic}
		</div>
		<div class="right">
			${timestamp}
			${judul}
			${jumlah}
		</div>
	</div>
	`;
};
