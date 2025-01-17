const RockInvoiceItems = (() => {
  class RockInvoiceItems {
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

      // populate from textarea data
      this.wakeup();

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
      const item = new Item(this);

      return item;
    }

    getTotals() {
      // get all totals
      // returns the subtotal
      // vat (like 7,5 = 123; 10 = 1230; 20 = 12300)
      // grandtotal
      return {
        subtotal: this.subtotal(),
        vat: this.getVatArray(),
        grandtotal: this.grandtotal(),
      };
    }

    /**
     * Returns an array of VAT rates plus their totals
     * eg
     * [
     *   [7.5, 123],
     *   [10, 1230],
     *   [20, 12300]
     * ]
     */
    getVatArray() {
      const vatArray = {};
      this.items().forEach((item) => {
        const vatRate = item.vat();
        if (!vatRate) return;
        const vatValue = (item.total() * vatRate) / 100;
        vatArray[vatRate] = (vatArray[vatRate] || 0) + vatValue;
      });

      // Format numbers after all calculations are done
      Object.keys(vatArray).forEach((key) => {
        vatArray[key] = Number(vatArray[key]).toFixed(2);
        if (vatArray[key] === "0.00") delete vatArray[key];
      });

      return vatArray;
    }

    grandtotal() {
      return this.items().reduce((total, item) => total + item.total(true), 0);
    }

    items() {
      const rows = this.itemstable.querySelectorAll("tbody.items > tr");
      return Array.from(rows)
        .map((tr) => tr._item)
        .filter((item) => item);
    }

    itemsArray() {
      return this.items().map((item) => item.toArray());
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
      this.textarea.value = JSON.stringify({
        items: this.itemsArray(),
      });
    }

    subtotal() {
      return this.items().reduce(
        (subtotal, item) => subtotal + item.total(),
        0
      );
    }

    update() {
      if (this.items().length > 0) {
        this.totalstable.removeAttribute("hidden");
        this.labels.removeAttribute("hidden");
        // update totals
        let totals = this.getTotals();

        // update subtotal
        this.totalstable.querySelector(".subtotal").textContent =
          totals.subtotal.toFixed(2);

        // update grandtotal
        this.totalstable.querySelector(".grandtotal").textContent =
          totals.grandtotal.toFixed(2);

        this.updateVatTotals();
      } else {
        this.totalstable.setAttribute("hidden", "");
        this.labels.setAttribute("hidden", "");
      }
      this.sleep();
    }

    updateVatTotals() {
      let vatArray = this.getVatArray();
      // remove all non-hidden vattotal rows
      this.totalstable
        .querySelectorAll("tr.vattotal:not([hidden])")
        .forEach((tr) => tr.remove());

      // use the hidden tr.vattotal as template
      const tpl = this.totalstable.querySelector("tr.vattotal[hidden]");

      // add new vattotal rows
      for (const [key, value] of Object.entries(vatArray)) {
        const clone = tpl.cloneNode(true);
        // write vatrate to .rate and value to .value
        clone.querySelector(".rate").textContent = key + "%";
        clone.querySelector(".value").textContent = value;
        clone.removeAttribute("hidden");
        // insert the node right before the last tr of the table
        this.totalstable.querySelector("tbody tr:last-child").before(clone);
      }
    }

    wakeup() {
      const data = JSON.parse(this.textarea.value);
      if (data.items) {
        data.items.forEach((item) => {
          this.addRow().setData(item.text, item.net, item.vat, item.quantity);
        });
      }
    }
  }

  class Item {
    constructor(field, addedItem) {
      this.field = field;
      this.tr = addedItem || field.li.querySelector("tbody tr:last-child");
      this.deleteButton = this.tr.querySelector(".delete-row");
      this.cloneButton = this.tr.querySelector(".clone-row");
      this.itemTotal = this.tr.querySelector(".total > strong");

      // store reference to this instance on the row dom element
      this.tr._item = this;

      // event listeners
      this.deleteButton.addEventListener("click", (e) => {
        e.preventDefault();
        this.deleteItem(this.deleteButton);
      });
      this.cloneButton.addEventListener("click", (e) => {
        e.preventDefault();
        this.clone();
      });
      this.selectOnClick();
      this.monitorInputs();

      // trigger first update
      this.update();
    }

    clone() {
      // Clone the current row
      const clone = this.tr.cloneNode(true);
      // Insert after current row
      this.tr.after(clone);
      const addedItem = this.tr.nextElementSibling;
      new Item(this.field, addedItem);
      this.update();
    }

    deleteItem(button) {
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
      // same for textarea
      this.tr.querySelector(".text textarea").addEventListener("input", () => {
        this.update();
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

    setData(text, net, vat, quantity) {
      this.tr.querySelector(".text textarea").value = text;
      this.tr.querySelector(".net input").value = net;
      this.tr.querySelector(".vat input").value = vat;
      this.tr.querySelector(".quantity input").value = quantity;
      this.update();
    }

    text() {
      console.log(this.tr.querySelector(".text textarea").value);
      return this.tr.querySelector(".text textarea").value;
    }

    /**
     * Get array ready to be used for storing in the textarea
     */
    toArray() {
      return {
        text: this.text(),
        net: this.net(),
        vat: this.vat(),
        quantity: this.quantity(),
      };
    }

    total(withVAT = false) {
      const total = this.net() * this.quantity();
      if (!withVAT) return total;
      return total * (1 + this.vat() / 100);
    }

    update() {
      this.itemTotal.textContent = this.total().toFixed(2);
      this.field.update();
    }

    vat() {
      return parseFloat(this.tr.querySelector(".vat input").value);
    }
  }

  return new RockInvoiceItems();
})();
