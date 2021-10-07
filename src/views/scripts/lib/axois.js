const DEFAULT_URL = "https://jsonplaceholder.typicode.com/";

class AXOIS {
	constructor(baseUrl = DEFAULT_URL) {
		this.baseUrl = baseUrl;
	}

	set_url(route) {
		if (route[0] === "/") route = route.substring(1);
		return `${this.baseUrl}${route}`;
	}

	async get(route) {
		const url = this.set_url(route);
		return await $.ajax({
			type: "GET",
			url,
		});
	}

	async post(route, body) {
		const url = this.set_url(route);
		return await $.ajax({
			type: "POST",
			url,
			data: body,
		});
	}

	async put(route, body) {
		const url = this.set_url(route);
		return await $.ajax({
			type: "PUT",
			url,
			data: body,
		});
	}

	async delete(route, body) {
		const url = this.set_url(route);
		return await $.ajax({
			type: "DELETE",
			url,
			data: body,
		});
	}
}

const axois = new AXOIS();

// usage example

// GET
// const res = await axois.get("todos/1");

// POST
// const res = await axois.post("posts",{title : "food", body : "bambang", userId : 1});

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
