//all class that defined here should declared on base.css

function generateHeader(user) {
	const logo = `<div class="logo" onclick="toHome()">Pameran Buku</div>`;
	const control = `
	<div class="control">
		${
			user
				? `<p>Welcome, ${user}</p><img class="cart" onclick="toCart()" src="${PUBLIC_ENDPOINT}/asset/cart.svg"/><button class="logout secondary" onclick="logout()">Logout</button>`
				: `<button class="login" onclick="toLogin()">Login</button>`
		}
	</div>`;
	return `${logo}${control}`;
}

function generateNavbar() {
	const target = document.getElementById("nav");
	const navigation = [
		{path: "/search", icon: "search"},
		{path: "/home", icon: "home"},
		{path: "/history", icon: "history"},
		{path: "/logout", icon: "logout"},
	];

	const url = window.location.href;
	const Navs = navigation.map((row) => {
		const active = url.includes(row.path);
		const icon = `../public/icons/${
			active ? `${row.icon}_active.svg` : `${row.icon}.svg`
		}`;

		return `<div class="navigation-item" onclick="redirect('${row.path}')">
			<img src=${icon} class="navigation-icon"/>
		</div>`;
	});

	target.innerHTML = `<nav class="navigation">${Navs}</nav>`;
}
