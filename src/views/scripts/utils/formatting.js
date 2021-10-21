const getDuration = (date) => {
	const temp = new Date(date);
	const now = new Date();
	const range = (now.getTime() - temp.getTime()) / 1000;
	const day = Math.floor(range / 86400);
	const hour = Math.floor(range / 3600) % 24;
	const min = Math.floor((range % 3600) / 60);
	const sec = Math.floor(range % 60);

	if (day === 0 && hour === 0 && min === 0 && sec < 60) {
		return "Baru Saja";
	} else {
		if (day > 0)
			return `${temp.getDate()} ${
				MONTH_NAME[temp.getMonth()]
			} ${temp.getFullYear()} | ${hour}:${min}`;
		if (hour > 0) return `${hour} jam yang lalu`;
		if (min > 0) return `${min} menit yang lalu`;
	}
};

const formatCurrency = (num) => {
	return new Intl.NumberFormat('id-ID', {
		style: 'currency',
		currency: 'IDR'
	}).format(num)
}