const getDorayakiPage = async (page = 1) => {
	const url = `dorayaki/get-pagination?page=${page}`;
	const res = await axois.get(url);
	return res;
};
