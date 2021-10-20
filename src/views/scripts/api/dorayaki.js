const getDorayakiPage = async (page = 1) => {
	const url = `dorayaki/get-pagination?page=${page}`;
	const res = await axois.get(url);
	return res;
};

const deleteDorayaki = async (dorayaki_id) => {
	const url = `/dorayaki/delete`;
	const body = {dorayaki_id};
	const res = await axois.post(url, body);
	redirect("/admin/dorayaki");
	return res;
};

const updateDorayaki = async (dorayaki_id) => {
	const ddt = "dorayaki-details-text";

	const name = document.querySelector(`.${ddt}.name input`).value;
	const description = document.querySelector(`.${ddt}.description input`).value;
	const price = Number(document.querySelector(`.${ddt}.price input`).value);
	const stock = Number(document.querySelector(`.${ddt}.stock input`).value);
	const thumbnail = document.querySelector(`.${ddt}.thumbnail input`).src;

	const payload = {dorayaki_id, name, description, price, stock, thumbnail};

	const url = `/dorayaki/update`;
	const res = await axois.post(url, payload);
	console.log("INI RES", res);
	// redirect(`/admin/dorayaki-details?id=${dorayaki_id}`);
	return res;
};