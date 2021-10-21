const getCurrentUser = async (page = 1) => {
	const url = `user/get-current-user`;
	const res = await axois.get(url);
	return res;
};

const checkUsername = async (username) => {
	const url = `user/check-username?username=${username}`
	const res = await axois.get(url);
	return res;
}

const checkEmail = async (username) => {
	const url = `user/check-email?email=${username}`
	const res = await axois.get(url);
	return res;
}
