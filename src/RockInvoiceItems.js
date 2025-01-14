var RockInvoiceItems;
(() => {
  class _RockInvoiceItems {
    fields = [];

    init() {
      this.fields.push(new Field());
    }
  }

  class Field {
    rows = [];

    constructor() {
      this.li = document.currentScript.closest("li.Inputfield");
      this.addRowButton = this.li.querySelector(".add-row");
      this.tpl = this.li.querySelector("template");
      this.itemstable = this.li.querySelector("table.rockinvoice-items-table");
      this.makeSortable();

      // event listeners
      this.addRowButton.addEventListener("click", (e) => {
        e.preventDefault();
        this.addRow();
      });
    }

    addRow() {
      // copy template and add it to the table
      let clone = this.tpl.content.cloneNode(true);
      this.li.querySelector("tbody").appendChild(clone);
      // get the new node and pass it to the Row class
      let row = new Row(this.li);
      this.rows.push(row);
    }

    deleteRow(button) {
      // find row from button element
      let row = button.closest("tr");
      // remove the row
      row.remove();
    }

    makeSortable() {
      $(this.itemstable.querySelector("tbody")).sortable({
        handle: ".sort-handle",
        cursor: "grabbing",
      });
    }
  }

  class Row {
    constructor(li) {
      this.tr = li.querySelector("tbody tr:last-child");
      this.deleteButton = this.tr.querySelector(".delete-row");

      // event listeners
      this.deleteButton.addEventListener("click", (e) => {
        e.preventDefault();
        this.deleteRow(this.deleteButton);
      });
    }

    deleteRow(button) {
      button.closest("tr").remove();
    }
  }

  RockInvoiceItems = new _RockInvoiceItems();
})();
