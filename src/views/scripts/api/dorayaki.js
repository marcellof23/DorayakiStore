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
  const body = { dorayaki_id };
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
  const thumbnail = document.querySelector(`#dorayaki-photo`).src;

  const payload = { dorayaki_id, name, description, price, stock, thumbnail };
  console.log("UPDATING DORAYAKI...", payload);

  const url = `/dorayaki/update`;
  
  try {
    const res = await axois.post(url, payload);
    redirect(`/admin/dorayaki-details?id=${dorayaki_id}`);
    return res;
  } catch (err) {
    console.log(err)
    ShowAlert('error', err.response, '', 'beforeBegin', 'dorayaki-details')
  }

  return null;
};

const createDorayaki = async () => {
  const ddt = "dorayaki-details-text";

  const name = document.querySelector(`.${ddt}.name input`).value;
  const description = document.querySelector(`.${ddt}.description input`).value;
  const price = Number(document.querySelector(`.${ddt}.price input`).value);
  const stock = Number(document.querySelector(`.${ddt}.stock input`).value);
  const thumbnail = document.querySelector(`#dorayaki-photo`).src;

  const payload = { name, description, price, stock, thumbnail };
  console.log("CREATING DORAYAKI...", payload);

  const url = `/dorayaki/create`;

  try {
    const res = await axois.post(url, payload);
    ShowAlert('success', 'Dorayaki has been successfully created!', '', 'beforeBegin', 'dorayaki-details')
    return res;
  } catch (err) {
    console.log(err)
    ShowAlert('error', err.response, '', 'beforeBegin', 'dorayaki-details')
  }

  return null;
};
