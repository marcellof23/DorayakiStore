const handleUploadPhoto = async (cb) => {
  const input = document.createElement("input");
  input.setAttribute("type", "file");
  input.setAttribute("accept", "image/*");
  input.click();

  input.onchange = async () => {
    const file = input.files ? input.files[0] : undefined;
    if (!file) return;

    const formData = new FormData();
    formData.append("userfile", file);

    const res = await axois.post("/dorayaki/upload-image", formData);

    console.log(JSON.stringify(res));

    cb(file);
    return file;
  };

  return null;
};

const generateFormData = (payload) => {
  const formData = new FormData();
  for (const [key, value] of Object.entries(payload)) {
    formData.append(key, value);
  }
  return formData;
};

function debounce(func, wait = 400, immediate = false) {
  let timeout;
  return function () {
    // @ts-ignore
    const context = this;
    const args = arguments;
    clearTimeout(timeout);
    timeout = setTimeout(function () {
      timeout = null;
      if (!immediate) func.apply(context, args);
    }, wait);
    if (immediate && !timeout) func.apply(context, args);
  };
}

const buildQuery = (object = {}, fields = [], page = 0) => {
  let res = "?";
  if (fields.length) {
    fields.forEach((f) => {
      res += object[f] ? `&${f}=${object[f]}` : "";
    });
  } else {
    for (const [key, value] of Object.entries(object)) {
      res += `&${key}=${value}`;
    }
  }
  res += `&page=${page}`;
  return res;
};

const adminRoute = async () => {
  try {
    const res = await getCurrentUser();
    const user = JSON.parse(res);
    const is_admin = parseInt(user.is_admin);

    if (!is_admin) redirect("/home");
    return user;
  } catch (err) {
    redirect("/login");
  }
};

const userRoute = async () => {
  try {
    const res = await getCurrentUser();
    const user = JSON.parse(res);
    console.log(user);
    const is_admin = parseInt(user.is_admin);

    if (is_admin) redirect("/admin/dorayaki");
    return user;
  } catch (err) {
    redirect("/login");
  }
};

const notLoggedInRoute = async () => {
  const res = await getCurrentUser();
  const user = JSON.parse(res);
  const is_admin = parseInt(user.is_admin);

  if (is_admin) {
    redirect("/admin/dorayaki");
  } else {
    redirect("/home");
  }
};

const redirect = (url, duration = 0) => {
  url = url[0] === "/" ? constructURL(url) : url;
  setTimeout(() => {
    window.location.href = url;
  }, duration);
};

const openTab = (url) => {
  window.open(url, "_newtab");
};

const getCookie = (name = "username") => {
  let cookiesArray = document.cookie.split(";");
  let cookiesObject = {};
  cookiesArray.map((row) => {
    let temp = row.trim();
    temp = temp.split("=");
    cookiesObject[temp[0]] = temp[1];
  });
  return cookiesObject[name];
};
