const DEFAULT_URL = "https://jsonplaceholder.typicode.com/";

class AXOIS {
	constructor(baseUrl = DEFAULT_URL) {
		this.baseUrl = baseUrl;
	}

	set_url(route) {
		if (route[0] === "/") route = route.substring(1);
		return `${this.baseUrl}${route}`;
	}

	obj_to_formdata(obj = {}) {
		const data = new FormData();
		for (const [key, value] of Object.entries(obj)) {
			data.append(key, value);
		}
		return data;
	}

	compose_request(url, method, data) {
		return new Promise(function (resolve, reject) {
			const req = new XMLHttpRequest();
			req.open(method, url);

			req.onload = function () {
				if (req.status >= 200 && req.status < 300) {
					resolve(req.response);
				} else {
					reject({status: req.status, statusText: req.statusText});
				}
			};

			req.onerror = function () {
				reject({
					status: req.status,
					statusText: req.statusText,
				});
			};

			if (method !== "GET") {
				req.send(data);
			} else {
				req.send();
			}
		});
	}

	async get(route) {
		const url = this.set_url(route);
		return await this.compose_request(url, "GET");
	}

	async post(route, payload) {
		const url = this.set_url(route);
		const data = this.obj_to_formdata(payload);
		return await this.compose_request(url, "POST", data);
	}

	async put(route, payload) {
		const url = this.set_url(route);
		const data = this.obj_to_formdata(payload);
		return await this.compose_request(url, "PUT", data);
	}

	async delete(route, payload) {
		const url = this.set_url(route);
		const data = this.obj_to_formdata(payload);
		return await this.compose_request(url, "DELETE", data);
	}
}

const axois = new AXOIS();

// WORKING EXAMPLE DOWN HERE

// const axois = new AXOIS("https://jsonplaceholder.typicode.com/");

// const data = {
// 	title: "foo",
// 	body: "bar",
// 	userId: 1,
// };

// const onGet = async () => {
// 	const res = await axois.get("todos/1");
// 	console.log("MASUK BANG");
// 	console.log(res);
// };

// const onPost = async () => {
// 	const res = await axois.post("posts", data);
// 	console.log("POST BANG!");
// 	console.log(res);
// };

// const onPut = async () => {
// 	const res = await axois.put("posts/1", data);
// 	console.log("PUT BANG!");
// 	console.log(res);
// };

// const onDelete = async () => {
// 	const res = await axois.delete("posts/1");
// 	console.log("DELETE BANG!");
// 	console.log(res);
// };

// onGet();
// onPost();
// onPut();
// onDelete();
