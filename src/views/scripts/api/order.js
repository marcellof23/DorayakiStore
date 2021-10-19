const getOrderPage = async (page = 1) => {
	const reqUrl = new URL(window.location.href);
	const type = reqUrl.searchParams.get("type") || "user";

	const url = `order/get-orders?page=${page}&type=${type}`;
	const res = await axois.get(url);
	return res;
};
