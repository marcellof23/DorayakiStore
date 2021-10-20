const getDorayakiPage = async (page = 1) => {
	const url = `dorayaki/get-pagination?page=${page}`;
	const res = await axois.get(url);
	return res;
};

const getDorayakiDetail = async (id = 1) => {
	const url = `dorayaki/get-details?dorayaki_id=${id}`;
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
	const thumbnail = "https://picsum.photos/200";
	// const thumbnail = document.querySelector(`.${ddt}.thumbnail input`).src;

	const payload = {dorayaki_id, name, description, price, stock, thumbnail};
	console.log("UPDATING DORAYAKI...", payload);

	const url = `/dorayaki/update`;
	const res = await axois.post(url, payload);
	console.log("INI RES", res);
	redirect(`/admin/dorayaki-details?id=${dorayaki_id}`);
	return res;
};

const createDorayaki = async () => {
	const ddt = "dorayaki-details-text";

	const name = document.querySelector(`.${ddt}.name input`).value;
	const description = document.querySelector(`.${ddt}.description input`).value;
	const price = Number(document.querySelector(`.${ddt}.price input`).value);
	const stock = Number(document.querySelector(`.${ddt}.stock input`).value);
	const thumbnail = "https://picsum.photos/200";

	const payload = {name, description, price, stock, thumbnail};
	console.log("CREATING DORAYAKI...", payload);

	const url = `/dorayaki/create`;
	const res = await axois.post(url, payload);
	console.log("INI RES", res);
	redirect("/admin/dorayaki");
	return res;
};