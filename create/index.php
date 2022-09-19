<?php

require_once '../../users/init.php';
if (!securePage($_SERVER['PHP_SELF'])){die();}

include_once("../db/db.php");
session_start();

$db = new Database();

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="../css/master.css" />
  <link rel="stylesheet" href="../css/create.css" />
  <script src="../js/create.js" charset="utf-8"></script>
  <title>QuickBrookes | Create</title>
</head>
<body>
  <header>
    <a href="https://platform.ambroseweb.co.uk"><img src="https://ambroseweb.co.uk/imgs/awg-rectangle-logo.png" alt="Ambrose Web Logo" /></a>
    <h1>QuickBrookes</h1>
  </header>

  <div class="back-arrow">
    <a href="../"><img src="../imgs/arrow-left.png" alt="Back Arrow" /></a>
  </div>

  <form action="./create.php" method="post">
    <fieldset class="details">
      <legend>Invoice Details</legend>

      <label for="date_created">Creation Date</label>
      <input type="date" name="date_created" readonly />

      <label for="due_period">Due Period (Days)</label>
      <input type="number" name="due_period" value="30" step="1" />

      <label for="customer">Customer</label>
      <input type="text" name="customer_name" readonly onclick="openCustomerSelection()" />
      <input type="hidden" name="customer_id" value="1" />
    </fieldset>

    <fieldset class="items">
      <legend>Invoice Items</legend>
      <table>
        <thead>
          <tr>
            <th style="width: 100%;">Description</th>
            <th>Unit Price</th>
            <th>Quantity</th>
            <th>Price</th>
          </tr>
        </thead>
        <tbody>
        </tbody>
        <tfoot>
          <tr>
            <td colspan="4">
              <button type="button" onclick="addRow()">
                <img src="../imgs/plus.png" alt="Add Button" />
              </button>
            </td>
          </tr>
          <tr>
            <td colspan="3">Total</td>
            <td>
              <input type="text" value="£ 0.00" class="total" readonly />
            </td>
          </tr>
        </tfoot>
      </table>
    </fieldset>
    <button type="submit">Save</button>
  </form>

  <div class="customer-selection">
    <input type="text" name="search-customers" placeholder="Search for a customer..." onkeyup="searchCustomers(this)" />
    <ul>
      <?php foreach ($db->customers->selectAll() as $customer) { ?>
        <li><button
          data-customer-id="<?php echo $customer['id'] ?>"
          data-customer-name="<?php echo $customer['name'] ?>"
          onclick="selectCustomer(this.dataset)"
        >
          <?php echo $customer['name'] ?> |
          <?php echo explode(",",$customer['address'])[0].", ".explode(",",$customer['address'])[3] ?></button></li>
      <?php } ?>
    </ul>
  </div>

</body>
</html>
