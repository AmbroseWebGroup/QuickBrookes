let itemCount = 1;

window.addEventListener("load", (_) => {
  let d = new Date();
  d.setDate(d.getDate() + 1);
  document.querySelector('[name=date_created]').valueAsDate = d;
  addRow();
}, false);

function customerSelect() {
  return;
}

function addRow() {
  let newElt = document.createElement("tr");
  newElt.innerHTML = `
    <td>
      <input type="text" name="description[]" class="description" placeholder="Item description ${itemCount}" />
    </td>
    <td>
      <input
        type="number"
        name="unit_price[]"
        value="0" step="0.01"
        class="unit_price"
        onchange="updatePrice(this)"
      />
    </td>
    <td>
      <input
        type="number"
        name="quantity[]"
        value="1"
        step="any"
        class="quantity"
        onchange="updatePrice(this)"
      />
    </td>
    <td>
      <input type="text" value="£ 0.00" class="price" readonly />
    </td>
    <td>
      <button type="button" class="remove" onclick="removeRow(this)">&#10006;</button>
    </td>
  `;

  document.querySelector("tbody").appendChild(newElt);

  itemCount++;
}

function removeRow(_elt) {
  if (document.querySelectorAll("tbody tr").length > 1) {
    _elt.parentNode.parentNode.remove();
  }
}

function updatePrice(_elt) {
  let item = _elt.parentNode.parentNode;
  let unit = item.querySelector(".unit_price").value;
  let qty = item.querySelector(".quantity").value;
  item.querySelector(".price").value = `£ ${(unit * qty).toFixed(2)}`;

  let total = document.getElementsByClassName("total")[0];
  total.value = "£ " + Array.from(
    document.querySelectorAll("tbody tr")
  ).reduce(
    (running, item) => {
      return running +
        (item.querySelector(".unit_price").value * item.querySelector(".quantity").value)
    }, 0
  ).toFixed(2);
}

function openCustomerSelection() {
  document.getElementsByClassName("customer-selection")[0].style.display = "grid";
}

function selectCustomer(_dataset) {
  document.querySelector("[name=customer_name]").value = _dataset.customerName;
  document.querySelector("[name=customer_id]").value = _dataset.customerId;
  document.getElementsByClassName("customer-selection")[0].style.display = "none";
}

function searchCustomers(_input) {
  let query = _input.value;
  for (let elt of document.querySelectorAll(".customer-selection li")) {
    elt.style.display =
      elt.querySelector("button").innerText.toUpperCase().search(query.toUpperCase()) > -1 ?
        "grid" : "none";
  }
}