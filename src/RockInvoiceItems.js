var RockInvoiceItems;
(() => {
  class _RockInvoiceItems {
    init() {
      new Field();
    }
  }

  class Field {
    constructor() {
      this.li = document.currentScript.closest("li.Inputfield");
      this.addRowButton = this.li.querySelector(".add-row");
      this.tpl = this.li.querySelector("template");
      this.labels = this.li.querySelector("thead.labels");
      this.itemstable = this.li.querySelector("table.rockinvoice-items-table");
      this.totalstable = this.li.querySelector("table.totals");
      this.textarea = this.li.querySelector(".InputfieldContent > textarea");

      // store instance of this class on the li dom element
      this.li._field = this;

      // make row items sortable
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

      // create new row
      new Row(this);

      // update totals
      this.update();
    }

    getTotals() {
      // get all totals
      // returns the subtotal
      // vat (like 7,5 = 123; 10 = 1230; 20 = 12300)
      // grandtotal
      return {
        subtotal: this.subtotal(),
        vat: 0,
        grandtotal: this.grandtotal(),
      };
    }

    grandtotal() {
      let total = 0;
      this.items().forEach((tr) => {
        total += tr._row.total(true);
      });
      return total;
    }

    items() {
      return this.itemstable.querySelectorAll("tbody.items > tr");
    }

    itemsJSON() {
      return Array.from(this.items()).map((tr) => {
        return {
          text: "TBD",
          net: tr.querySelector(".net input").value,
          vat: tr.querySelector(".vat input").value,
          quantity: tr.querySelector(".quantity input").value,
        };
      });
    }

    makeSortable() {
      $(this.itemstable.querySelector("tbody")).sortable({
        handle: ".sort-handle",
        cursor: "grabbing",
        update: () => this.update(),
      });
    }

    /**
     * Write data to textarea
     */
    sleep() {
      if (!this.items().length) {
        this.textarea.value = "";
        return;
      }
      this.textarea.value = JSON.stringify(
        {
          items: this.itemsJSON(),
          totals: JSON.stringify(this.getTotals()),
        },
        null,
        // spaces for indentation (debugging)
        0
      );
    }

    subtotal() {
      let subtotal = 0;
      this.items().forEach((tr) => {
        subtotal += tr._row.total();
      });
      return subtotal;
    }

    update() {
      if (this.items().length > 0) {
        this.totalstable.removeAttribute("hidden");
        this.labels.removeAttribute("hidden");
        // update totals
        let totals = this.getTotals();
        this.totalstable.querySelector(".subtotal").textContent =
          totals.subtotal.toFixed(2);
        this.totalstable.querySelector(".grandtotal").textContent =
          totals.grandtotal.toFixed(2);
      } else {
        this.totalstable.setAttribute("hidden", "");
        this.labels.setAttribute("hidden", "");
      }
      this.sleep();
    }
  }

  class Row {
    constructor(field) {
      this.field = field;
      this.tr = field.li.querySelector("tbody tr:last-child");
      this.deleteButton = this.tr.querySelector(".delete-row");
      this.rowTotal = this.tr.querySelector(".total > strong");

      // store reference to this instance on the row dom element
      this.tr._row = this;

      // event listeners
      this.deleteButton.addEventListener("click", (e) => {
        e.preventDefault();
        this.deleteRow(this.deleteButton);
      });
      this.selectOnClick();
      this.monitorInputs();

      // trigger first update
      this.update();
    }

    deleteRow(button) {
      button.closest("tr").remove();
      this.update();
    }

    monitorInputs() {
      // whenever any input changes, update totals
      this.tr.querySelectorAll("input").forEach((input) => {
        // Listen for both input and change events
        ["input", "change"].forEach((event) => {
          input.addEventListener(event, () => {
            this.update();
          });
        });
      });
    }

    net() {
      return parseFloat(this.tr.querySelector(".net input").value);
    }

    quantity() {
      return parseFloat(this.tr.querySelector(".quantity input").value);
    }

    selectOnClick() {
      // when any input is clicked, select the content
      this.tr.querySelectorAll("input").forEach((input) => {
        input.addEventListener("click", () => {
          input.select();
        });
      });
    }

    total(withVAT = false) {
      const total = this.net() * this.quantity();
      if (!withVAT) return total;
      return total * (1 + this.vat() / 100);
    }

    update() {
      this.rowTotal.textContent = this.total().toFixed(2);
      this.field.update();
    }

    vat() {
      return parseFloat(this.tr.querySelector(".vat input").value);
    }
  }

  RockInvoiceItems = new _RockInvoiceItems();
})();
