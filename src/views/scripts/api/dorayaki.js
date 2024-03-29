const getDorayakiPage = async (page = 1) => {
  const url = `dorayaki/get-pagination?page=${page}`;
  const res = await axois.get(url);
  console.log("MASUK GAN", res);
  return res;
};

const getPopularDorayaki = async () => {
  const url = `dorayaki/get-popular-variant`;
  const res = await axois.get(url);
  return res;
};

const searchDorayaki = async (id, url) => {
  const q = document.getElementById(id).value;
  redirect(`${url}?query=${q}`);
};

const getSearchedDorayaki = async () => {
	const req = new URL(window.location.href);
	const query = req.searchParams.get("query");
	const page = parseInt(req.searchParams.get("page")) || 1;
	if (!query) return await getDorayakiPage(page);
	const url = `dorayaki/get-by-query?query=${query}&page=${page}`;
	const res = await axois.get(url);
	console.log("INI RES", JSON.parse(res));
	return res;
};

const getDorayakiDetail = async (id = 1) => {
  const url = `dorayaki/get-details?dorayaki_id=${id}`;
  const res = await axois.get(url);
  return res;
};

const buyDorayaki = async (dorayaki_id, counter_id) => {
  const amount = parseInt(document.getElementById(counter_id).innerHTML);
  const payload = { dorayaki_id, amount };
  console.log(payload);

  const url = `/order/create-order`;

  try {
    const res = await axois.post(url, payload);
    console.log(res);
    //redirect(`/admin/dorayaki-details?id=${dorayaki_id}`);
    return res;
  } catch (err) {
    console.log(err);
    ShowAlert("error", err.response, "", "afterBegin", "buy-container .form");
  }

  return null;
  //tinggal tembak API BD
};

const deleteDorayaki = async (dorayaki_id) => {
  const url = `/dorayaki/delete`;
  const body = { dorayaki_id };
  const res = await axois.post(url, body);
  redirect("/admin/dorayaki");
  return res;
};

const updateDorayaki = async (dorayaki_id) => {
  const ddt = "dorayaki-details-text";

  const btn = document.querySelector(`.btn.btn-primary`);
  btn.textContent = 'Loading...';
  btn.classList.toggle('btn-secondary');

  const name = document.querySelector(`.${ddt}.name span`).textContent;
  const description = document.querySelector(`.${ddt}.description textarea`).value;
  const price = Number(document.querySelector(`.${ddt}.price input`).value);
  const stock = Number(document.querySelector(`.${ddt}.stock input`).value);
  const thumbnail = document.querySelector(`#dorayaki-photo`).src;

  const payload = { dorayaki_id, name, description, price, stock, thumbnail };
  console.log("UPDATING DORAYAKI...", payload);

  const url = `/dorayaki/update`;

  try {
    const res = await axois.post(url, payload);
    btn.textContent = 'Save changes';
    btn.classList.toggle('btn-secondary');
    console.log(res);
    if (res == 'Dorayaki request submitted') {
      ShowAlert("success", res, "", "beforeBegin", "dorayaki-details");
      setTimeout(() => redirect(`/admin/dorayaki-details?id=${dorayaki_id}`), 2000);
    } else {
      redirect(`/admin/dorayaki-details?id=${dorayaki_id}`);
    }
    return res;
  } catch (err) {
    console.log(err);
    ShowAlert("error", err.response, "", "beforeBegin", "dorayaki-details");
    btn.textContent = 'Save changes';
    btn.classList.toggle('btn-secondary');
  }

  return null;
};

const createDorayaki = async () => {
	const ddt = "dorayaki-details-text";

	const name = document.querySelector(`.${ddt}.recipe_id`).value;
	const description = document.querySelector(
		`.${ddt}.description textarea`
	).value;
	const price = Number(document.querySelector(`.${ddt}.price input`).value);
	const stock = Number(document.querySelector(`.${ddt}.stock input`).value);
	const thumbnail = document.querySelector(`#dorayaki-photo`).src;

	const payload = {name, description, price, stock, thumbnail};

	const url = `/dorayaki/create`;

	try {
		const res = await axois.post(url, payload);
		ShowAlert(
			"success",
			"Dorayaki has been successfully created!",
			"",
			"beforeBegin",
			"dorayaki-details"
		);
		return res;
	} catch (err) {
		console.log(err);
		ShowAlert("error", err.response, "", "beforeBegin", "dorayaki-details");
	}

	return null;
};

const getAllDorayaki = async () => {
	try {
		const url = "/dorayaki/get-all-dorayaki";
		const res = await axois.get(url);
		return JSON.parse(res);
	} catch (err) {
		console.log(err);
		ShowAlert("error", err.response, "", "beforeBegin", "dorayaki-details");
	}
};

const getRecipes = async () => {
	try {
		const url = "/dorayaki/get-recipe";
		const res = await axois.get(url);
		return JSON.parse(res);
	} catch (err) {}
};