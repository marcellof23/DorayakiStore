class Modal {
	constructor(id, isVisible = false, children, classname = "") {
		this.id = id;
		this.isVisible = isVisible;
		this.children = children;
		this.classname = classname;
	}

	open() {
		return `dom = document.getElementById("${this.id}"); dom.classList.remove("hidden"); dom.classList.add("visible")`;
	}

	close() {
		return `dom = document.getElementById("${this.id}"); dom.classList.remove("visible"); dom.classList.add("hidden")`;
	}

	render() {
		return `
      <div class="modal ${this.isVisible ? "visible" : "hidden"}" id="${
			this.id
		}">
        <div class="modal-background" onclick='${this.close()}'></div>
        <div class="modal-content" class="${this.classname}">
          ${this.children}
        </div>
      </div>
    `;
	}
}

class ConfirmationModal extends Modal {
	constructor(
		id,
		isVisible = false,
		onOk,
		onCancel,
		children,
		classname = "",
		onOkText = "Ya",
		onCancelText = "Tidak"
	) {
		super(id, isVisible, children, classname);
		this.onOk = onOk;
		this.onCancel =
			onCancel ||
			`dom = document.getElementById("${id}"); dom.classList.remove("visible"); dom.classList.add("hidden")`;
		this.onOkText = onOkText;
		this.onCancelText = onCancelText;
	}

	render() {
		return `
      <div class="modal ${this.isVisible ? "visible" : "hidden"}" id="${
			this.id
		}">
        <div class="modal-background" onclick='${this.close()}'></div>
        <div class="modal-content" class="${this.classname}">
          <p>${this.children}</p>
          <div class="button-container">
            ${Button(this.onCancelText, false, this.onCancel)}
            ${Button(this.onOkText, true, this.onOk)}
          </div>
        </div>
      </div>
    `;
	}
}
