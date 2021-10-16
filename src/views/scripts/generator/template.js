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
  const navigation = [
    { path: "/search", icon: "search" },
    { path: "/home", icon: "home" },
    { path: "/history", icon: "history" },
    { path: "/logout", icon: "logout" },
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

  return `<nav class="navigation">${Navs.join("")}</nav>`;
}

function generateNavbarAdmin() {
  const navigation = [
    { path: "/home", icon: "home" },
    { path: "/history", icon: "history" },
    { path: "/logout", icon: "logout" },
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

  return `<nav class="navigation">${Navs.join("")}</nav>`;
}

function pageTitle(title) {
  return `<h2 class="page-title">${title}</h2>`;
}

function generate_table() {
  return `
	<table class="table">
		<col style="width:10%">
		<col style="width:18%">
		<col style="width:18%">
		<col style="width:30%">
		<col style="width:12%">
		<col style="width:12%">
		<tr>
			<th class="table-head first-row">No</th>
			<th class="table-head">Thumbnail</th>
			<th class="table-head">Nama Dorayaki</th>
			<th class="table-head">Description</th>
			<th class="table-head">Price</th>
			<th class="table-head">Stock</th>
		</tr>
		<tr>
			<td class="table-data first-row">1</td>
			<td class="table-data">Maria Anders</td>
			<td class="table-data">Germany</td>
			<td class="table-data">Germany</td>
			<td class="table-data">Germany</td>
			<td class="table-data">Germany</td>
		</tr>
		<tr>
			<td class="table-data first-row">2</td>
			<td class="table-data">Francisco Chang</td>
			<td class="table-data">Mexico</td>
			<td class="table-data">Germany</td>
			<td class="table-data">Germany</td>
			<td class="table-data">Germany</td>
		</tr>
		<tr>
			<td class="table-data first-row">3</td>
			<td class="table-data">Francisco Chang</td>
			<td class="table-data">Mexico</td>
			<td class="table-data">Germany</td>
			<td class="table-data">Germany</td>
			<td class="table-data">Germany</td>
		</tr>
		<tr>
			<td class="table-data first-row">4</td>
			<td class="table-data">Francisco Chang</td>
			<td class="table-data">Mexico</td>
			<td class="table-data">Germany</td>
			<td class="table-data">Germany</td>
			<td class="table-data">Germany</td>
		</tr>
		
	</table>`;
}
