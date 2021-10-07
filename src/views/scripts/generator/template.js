//all class that defined here should declared on index.css

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
