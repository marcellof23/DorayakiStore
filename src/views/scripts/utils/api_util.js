const handleUploadPhoto = async (cb) => {
	const input = document.createElement("input");
	input.setAttribute("type", "file");
	input.setAttribute("accept", "image/*");
	input.click();

	input.onchange = async () => {
		const file = input.files ? input.files[0] : undefined;
		if (!file) return;

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

const redirect = (url, duration = 0) => {
	url = url[0] === "/" ? constructURL(url) : url;
	setTimeout(() => {
		window.location.href = url;
	}, duration);
};;;

const openTab = (url) => {
	window.open(url, "_newtab");
};
