const getCurrentUser = async (page = 1) => {
	const url = `user/get-current-user`;
	const res = await axois.get(url);
	return res;
};
