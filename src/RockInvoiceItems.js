var RockInvoiceItems;
(() => {
  class _RockInvoiceItems {
    fields = [];

    init() {
      this.fields.push(new Field());
    }
  }

  class Field {
    constructor() {
      this.li = document.currentScript.closest("li.Inputfield");
      this.addItemButton = this.li.querySelector(".add-item");
      this.tpl = this.li.querySelector("template");

      // event listeners
      this.addItemButton.addEventListener("click", this.addItem.bind(this));
    }

    addItem(e) {
      e.preventDefault();

      // copy template and add it to the table
      let clone = this.tpl.content.cloneNode(true);
      this.li.querySelector("tbody").appendChild(clone);
    }
  }

  class Row {}

  RockInvoiceItems = new _RockInvoiceItems();
})();
