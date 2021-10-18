const AdminHomePage = async () => {
  const target = document.getElementById("home-admin");

  let curr_page = 1;

  function addPageNumber() {
    curr_page++;
  }

  function minPageNumber() {
    curr_page--;
  }

  async function fetchingData() {
    const axois = new AXOIS("/");

    const res = await axois.get(
      `api/dorayaki/get-pagination?page=${curr_page}`
    );
    return res;
  }

  const res = await fetchingData();

  const components = `
		${generateNavbarAdmin()}
		<div class="dorayaki-management-container">
			${pageTitle("Dorayaki Management")}
      <div class="search-container">
        ${SearchBar()}
        <button onclick="submit" class="add-dorayaki">
          Add Dorayaki
        </button>
      </div>
      <div class="table-container">
       ${generate_table(res)}
       <div class="pagination-container">
        <p class="pagination-number"><span id="button1"> < </span>   <span class="button2"> > </span> </p>
      </div>
      </div>  
		</div>
    <script>
      var box = document.getElementById("button1");
      var isBlue = true;
      box.onclick = function () {
        console.log("WOI");
      };
    </script>
	`;
  target.innerHTML = components;
};

const DorayakiDetailsPage = () => {
  const target = document.getElementById("dorayaki-details-page");

  const components = `
		${generateNavbarAdmin()}
		<div class="dorayaki-management-container">
			${pageTitle("Dorayaki Management")}
      <div class="doriyaki-details">
        <img src="" alt="foto doriyaki" id="dorayaki-photo" />
        <div class="doriyaki-details-main">
          <div class="doriyaki-details-text">
            <h3>Name</h3>
            <span>{name}</span>
          </div>
          <div class="doriyaki-details-text">
            <h3>Price</h3>
            <span>{price}</span>
          </div>
          <div class="doriyaki-details-text">
            <h3>Stock</h3>
            <span>{stock}</span>
          </div>
          <div class="doriyaki-details-text" style="margin-bottom:10px">
            <h3>Description</h3>
            <p>{description}</p>
          </div>
          <button class="doriyaki-button primary">Edit Dorayaki</button>
          <button class="doriyaki-button outline">Delete Dorayaki</button>
        </div>
      </div>
		</div>
	`;

  target.innerHTML = components;
};

const DorayakiEditPage = () => {
  const target = document.getElementById("dorayaki-edit-page");

  const components = `
		${generateNavbarAdmin()}
		<div class="dorayaki-management-container">
			${pageTitle("Dorayaki Management")}
      <div class="doriyaki-details">
        <img src="" alt="foto doriyaki" id="dorayaki-photo" />
        <form class="doriyaki-details-main">
          <div class="doriyaki-details-text">
            <h3>Name</h3>
            <input name="name" value="{name}" />
          </div>
          <div class="doriyaki-details-text">
            <h3>Price</h3>
            <input name="price" type="number" />
          </div>
          <div class="doriyaki-details-text">
            <h3>Stock</h3>
            <input name="stock" type="number" />
          </div>
          <div class="doriyaki-details-text" style="margin-bottom:10px">
            <h3>Description</h3>
            <textarea name="description" rows="4" cols="50"></textarea>
          </div>
          <input type="submit" class="doriyaki-button primary" value="Save changes" />
          <button class="doriyaki-button outline">Cancel</button>
        </form>
      </div>
		</div>
	`;

  target.innerHTML = components;
};

const DorayakiAddPage = () => {
  const target = document.getElementById("dorayaki-add-page");

  const components = `
		${generateNavbarAdmin()}
		<div class="dorayaki-management-container">
			${pageTitle("Dorayaki Management")}
      <div class="doriyaki-details">
        <img src="" alt="foto doriyaki" id="dorayaki-photo" />
        <form class="doriyaki-details-main">
          <div class="doriyaki-details-text">
            <h3>Name</h3>
            <input name="name" value="{name}" />
          </div>
          <div class="doriyaki-details-text">
            <h3>Price</h3>
            <input name="price" type="number" />
          </div>
          <div class="doriyaki-details-text">
            <h3>Stock</h3>
            <input name="stock" type="number" />
          </div>
          <div class="doriyaki-details-text" style="margin-bottom:10px">
            <h3>Description</h3>
            <textarea name="description" rows="4" cols="50"></textarea>
          </div>
          <input type="submit" class="doriyaki-button primary" value="Add new dorayaki" />
          <button class="doriyaki-button outline">Cancel</button>
        </form>
      </div>
		</div>
	`;

  target.innerHTML = components;
};
